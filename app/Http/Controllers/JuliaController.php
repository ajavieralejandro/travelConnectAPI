<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\PaqueteJulia;
use Carbon\Carbon;
use Exception;
use SimpleXMLElement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Http;
use App\Models\Paquete;

class JuliaController extends Controller
{
    public function getPaquetes(Request $request)
    {
        $url = 'http://ycixweb.juliatours.com.ar/WSJULIADEMO/WSJULIA.asmx';
        $soapAction = 'http://ycix.sytes.net/WS_jw_PAQUETES_CABECERA';

        $xml = $this->buildSoapRequest($request);

        $client = new Client(['timeout' => 300]);

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'text/xml; charset=utf-8',
                    'SOAPAction' => $soapAction
                ],
                'body' => $xml
            ]);

            $xmlResponse = $response->getBody()->getContents();
            Log::debug('Raw XML Response:', ['xml' => $xmlResponse]);
            return $this->processXmlResponse($xmlResponse);

        } catch (RequestException $e) {
            Log::error('SOAP Request Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'SOAP Request Failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function processXmlResponse(string $xmlResponse)
    {
        try {

            $xml = simplexml_load_string($xmlResponse, "SimpleXMLElement", LIBXML_NOCDATA);
            $processed = $this->processRows(json_decode(json_encode($xml), true));



            return response()->json([
                'success' => true,
                'message' => 'Paquetes procesados exitosamente',
                'count' => count($processed),
                'data' => $processed
            ]);

        } catch (Exception $e) {
            Log::error('XML Processing Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Processing Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function registerNamespaces(SimpleXMLElement $xml): void
    {
        // Registrar todos los namespaces posibles
        $namespaces = $xml->getNamespaces(true);
        foreach ($namespaces as $prefix => $ns) {
            $xml->registerXPathNamespace($prefix ?: 'default', $ns);
        }
    }

    private function hasSoapFault(SimpleXMLElement $xml): bool
    {
        return !empty($xml->xpath('//soap:Fault')) || !empty($xml->xpath('//*[local-name()="Fault"]'));
    }

    private function extractFaultString(SimpleXMLElement $xml): string
    {
        $fault = $xml->xpath('//*[local-name()="faultstring"]');
        return $fault ? (string)$fault[0] : 'Unknown SOAP Error';
    }
    private function extractDataRows(SimpleXMLElement $xml): array
    {
        // Obtener todos los namespaces del XML
        $namespaces = $xml->getNamespaces(true);

        // Registrar manualmente el namespace SOAP si existe
        $soapNamespace = null;
        foreach ($namespaces as $prefix => $uri) {
            if (strpos($uri, 'schemas.xmlsoap.org/soap/envelope/') !== false) {
                $soapNamespace = $uri;
                $xml->registerXPathNamespace('soap', $uri);
                break;
            }
        }

        // Registrar los demás namespaces dinámicamente
        foreach ($namespaces as $prefix => $uri) {
            if ($prefix === '') {
                $prefix = 'ns'; // Asignar un prefijo por defecto si no tiene
            }
            $xml->registerXPathNamespace($prefix, $uri);
        }

        // Construir la consulta XPath de manera más robusta
        $query = '
            //*[local-name()="Body"]
            //*[local-name()="Table" or
               local-name()="NewDataSet" or
               local-name()="diffgram" or
               contains(local-name(), "Result")]
            //*[not(namespace-uri()) or namespace-uri() = ""]
        ';

        $rows = $xml->xpath($query);

        return $rows ?: [];
    }


    private function processRows( $rows): array
    {

        $processed = [];
        $rows = $rows['Row'];
        foreach ($rows as $row) {
            try {
                $package = $this->savePackage($row);

                $processed[] = $package;
            } catch (Exception $e) {
                Log::error('Error processing row:', [
                    'error' => $e->getMessage()
                ]);
            }
        }
        return $processed;
    }


    private function parseRow(SimpleXMLElement $row): array
    {
        // Mapeo dinámico de campos
        $data = [];
        foreach ($row->children() as $element) {
            $name = $element->getName();
            $value = (string)$element;

            // Limpiar namespaces del nombre del campo
            $cleanName = preg_replace('/^.*:/', '', $name);
            $data[$cleanName] = $value;
        }

        // Campos requeridos
        $required = ['IDPAQUETE', 'NOMBRE', 'VIGENCIADESDE', 'VIGENCIAHASTA'];
        foreach ($required as $field) {
            if (!isset($data[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }

        return [
            'IDPAQUETE' => $data['IDPAQUETE'],
            'NOMBRE' => $data['NOMBRE'],
            'IDDESTINO' => $data['IDDESTINO'] ?? null,
            'CANTNOCHES' => (int)($data['CANTNOCHES'] ?? 0),
            'TIPOPAQUETE' => $data['TIPOPAQUETE'] ?? '0',
            'IZMONEDA' => $data['IZMONEDA'] ?? 'USD',
            'VIGENCIADESDE' => Carbon::parse($data['VIGENCIADESDE']),
            'VIGENCIAHASTA' => Carbon::parse($data['VIGENCIAHASTA']),
            'DESCRIPCION' => $this->cleanRtf($data['DESCRIPCION'] ?? ''),
            'RESERVAHABILITADA' => ($data['RESERVAHABILITADA'] ?? 'F') === 'V'
        ];
    }

    private function savePackage( $rowData)
    {
       $packege = $package = Paquete::updateOrCreate(
        ['paquete_externo_id' => $rowData['IDPAQUETE'] . '_julia'],
        [
            'titulo' => $rowData['NOMBRE'],
            'id_destino' => $rowData['IDDESTINO'],
            'cant_noches' => $rowData['CANTNOCHES'],
            'tipo_producto' => $this->mapTipoProducto($rowData['TIPOPAQUETE']),
            'tipo_moneda' => $rowData['IZMONEDA'],
            'fecha_vigencia_desde' => Carbon::parse($rowData['VIGENCIADESDE']),
            'fecha_vigencia_hasta' => Carbon::parse($rowData['VIGENCIAHASTA']),
            'fecha_modificacion' => now(),
            'activo' => $rowData['RESERVAHABILITADA'] === 'V', // Asumimos que 'V' es verdadero
            'pais' => 'BR',
            'ciudad' => 'RIO',
            'ciudad_iata' => $this->getIataCode('RIO'),
            'componentes' => $this->extraerComponentes($rowData['DESCRIPCION']),
            'categorias' => $this->determinarCategorias($rowData),
            'transporte' => $this->determinarTransporte($rowData['NOMBRE']),
            'usuario' => 'Julia',
            'usuario_id' => 1
        ]
    );
        return $packege;
    }

    private function handleSoapError(RequestException $e): \Illuminate\Http\JsonResponse
    {
        $errorMessage = $e->getMessage();
        $statusCode = 500;

        if ($e->hasResponse()) {
            try {
                $xmlError = new SimpleXMLElement($e->getResponse()->getBody()->getContents());
                $errorMessage = $this->extractFaultString($xmlError);
                $statusCode = $e->getResponse()->getStatusCode();
            } catch (Exception $ex) {
                Log::error('Error parseando error SOAP:', ['error' => $ex->getMessage()]);
            }
        }

        return response()->json([
            'error' => 'Error en comunicación SOAP',
            'message' => $errorMessage
        ], $statusCode);
    }

    // Helpers implementados
    private function cleanRtf(string $rtfText): string
    {
        return trim(strip_tags(preg_replace(
            '/\\\\([a-z]{1,})(-?\d{1,})?|[\{\}]/i',
            '',
            str_replace(['\\par', '\\pard'], ' ', $rtfText)
        )));
    }

    private function mapTipoProducto(string $tipo): string
    {
        return [
            '1' => 'Terrestre',
            '2' => 'Aéreo',
            '3' => 'Crucero'
        ][$tipo] ?? 'Otro';
    }

    private function determinarTransporte(string $nombre): string
    {
        $nombre = strtoupper($nombre);
        if (str_contains($nombre, 'AEREO')) return 'Aéreo';
        if (str_contains($nombre, 'BUS')) return 'Terrestre';
        return 'Combinado';
    }

    private function extraerComponentes(string $descripcion): array
    {
        $limpio = strtoupper($this->cleanRtf($descripcion));
        $componentes = [];
        if (str_contains($limpio, 'TRASLADO')) $componentes[] = 'Traslados';
        if (str_contains($limpio, 'HOTEL')) $componentes[] = 'Alojamiento';
        if (str_contains($limpio, 'EXCURSION')) $componentes[] = 'Excursiones';
        return array_unique($componentes);
    }

    private function determinarCategorias(array $rowData): array
    {
        $categorias = [];
        if ($rowData['CANTNOCHES'] > 7) $categorias[] = 'LargaEstadia';
        if ($rowData['RESERVAHABILITADA']) $categorias[] = 'ReservaInmediata';
        return $categorias;
    }

    private function getIataCode(string $ciudad): string
    {
        return [
            'RIO' => 'GIG',
            'BUE' => 'EZE',
            'MIA' => 'MIA'
        ][strtoupper($ciudad)] ?? '';
    }


function obtenerCodigosPorDestino($destino) {
    if (!$destino) {
        return null;
    }

    // Extraer la ciudad del destino ("CIUDAD - PAÍS" → "CIUDAD")
    $ciudadPrincipal = trim(explode(' - ', $destino)[0]);

    $response =  DB::table('ciudadesJulia')
        ->select('codigo_ciudad', 'codigo_pais')
        ->where(function ($query) use ($ciudadPrincipal) {

            $query->where('nombre_pais', 'like', "%{$ciudadPrincipal}%")
                ->orWhere('nombre_ciudad', 'like', "%{$ciudadPrincipal}%")
                ->orWhere('codigo_ciudad', 'like', "%{$ciudadPrincipal}%");
        })
        ->first();
        return $response;

}

public function enviarPaquetes(Request $request)
    {
        // URL del servicio SOAP
        $url = 'http://ycixweb.juliatours.com.ar/WSJULIADEMO/WSJULIA.asmx/WS_jw_PAQUETES_CABECERA';

        // Datos a enviar
        $origenCodigo = $this->obtenerCodigoPorOrigen($request->origen)?->codigo ?? '';
        $destinoCodigos = $this->obtenerCodigosPorDestino($request->destino);

        // Suponiendo que `obtenerCodigosPorDestino` devuelve un arreglo con las claves 'pais' y 'ciudad'.
        $destinoPais = $destinoCodigos->codigo_pais?? '';
        $destinoCiudad = $destinoCodigos->codigo_ciudad ?? '';
        // Ahora se reemplaza en el arreglo $data
        $data = [
            'Token' => '865EF1C9-CC67-4F78-A9B4-220F983DC375',
            'Origen' => $origenCodigo,
            'DestinoIZPais' => $destinoPais,
            'DestinoIZCiudad' => $destinoCiudad,
            'Ocupacion' => '0200',
            'VigenciaDesde' => '2025-02-10',
            'VigenciaHasta' => '2025-10-02',
            'IDPaquete' => '0',
            'Nombre' => '',
            'OrdenadoPor' => '1',
            'AscDes' => 'A',
        ];

        // Hacer la solicitud POST
        $response = Http::asForm()->post($url, $data);
        $xmlResponse = $response->getBody()->getContents();
        return $this->processXmlResponse($xmlResponse);

        // Obtener la respuesta
        if ($response->successful()) {
            // Si la solicitud fue exitosa, procesamos la respuesta
            $respuesta = $response->body(); // O puedes usar ->json() si la respuesta es JSON
            return response()->json([
                'success' => true,
                'data' => $respuesta,
            ]);
        } else {
            // Si hubo un error, lo manejamos
            return response()->json([
                'success' => false,
                'error' => $response->status(),
                'message' => $response->body(),
            ]);
        }
    }

function obtenerCodigoPorOrigen($origen) {
    if (!$origen) {
        return null;
    }
    // Extraer la parte principal antes de " - " y normalizar
    $ciudadPrincipal = strtoupper(trim(explode(' - ', $origen)[0]));

    $response =  DB::table('origenJulia')
        ->select('codigo')
        ->where('ciudad', 'like', "%{$ciudadPrincipal}%")
        ->first();
        return $response;
}
}
