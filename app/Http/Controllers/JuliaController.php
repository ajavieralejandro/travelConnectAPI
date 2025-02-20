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

class JuliaController extends Controller
{
    public function getPaquetes()
    {
        $url = 'http://ycixweb.juliatours.com.ar/WSJULIADEMO/WSJULIA.asmx';
        $soapAction = 'http://ycix.sytes.net/WS_jw_PAQUETES_CABECERA';

        $xml = $this->buildSoapRequest();
        $client = new Client(['timeout' => 30]);

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
            $xml = new SimpleXMLElement($xmlResponse);
            $this->registerNamespaces($xml);

            if ($this->hasSoapFault($xml)) {
                $error = $this->extractFaultString($xml);
                Log::error('SOAP Fault:', ['error' => $error]);
                throw new Exception($error);
            }

            $rows = $this->extractDataRows($xml);
            Log::info('Rows extracted:', ['count' => count($rows)]);

            $processed = $this->processRows($rows);

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
        // XPath genérico para diferentes estructuras
        return $xml->xpath('
            //*[local-name()="Table"] |
            //*[local-name()="NewDataSet"]/* |
            //*[local-name()="diffgram"]/*/* |
            //*[contains(local-name(), "Result")]//*
        ') ?: [];
    }

    private function processRows(array $rows): array
    {
        $processed = [];
        foreach ($rows as $row) {
            try {
                $rowData = $this->parseRow($row);
                $this->savePackage($rowData);
                $processed[] = $rowData;
            } catch (Exception $e) {
                Log::error('Error processing row:', [
                    'error' => $e->getMessage(),
                    'row' => $row->asXML()
                ]);
            }
        }
        return $processed;
    }

    private function buildSoapRequest(): string
{
    return <<<XML
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ycix="http://ycix.sytes.net">
        <soapenv:Header/>
        <soapenv:Body>
            <ycix:WS_jw_PAQUETES_CABECERA>
                <ycix:Token>B956AA63-DA4B-4A94-AE18-A8CFD6785C3E</ycix:Token>
                <ycix:Origen>B</ycix:Origen>
                <ycix:DestinoIZPais>BR</ycix:DestinoIZPais>
                <ycix:DestinoIZCiudad>RIO</ycix:DestinoIZCiudad>
                <ycix:Ocupacion>0200</ycix:Ocupacion>
                <ycix:VigenciaDesde>2025-05-10</ycix:VigenciaDesde>
                <ycix:VigenciaHasta>2025-10-10</ycix:VigenciaHasta>
                <ycix:IDPaquete>0</ycix:IDPaquete>
                <ycix:Nombre></ycix:Nombre>
                <ycix:OrdenadoPor>1</ycix:OrdenadoPor>
                <ycix:AscDes>D</ycix:AscDes>
            </ycix:WS_jw_PAQUETES_CABECERA>
        </soapenv:Body>
    </soapenv:Envelope>
    XML;
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

    private function savePackage(array $rowData): void
    {
        PaqueteJulia::updateOrCreate(
            ['paquete_externo_id' => $rowData['IDPAQUETE']],
            [
                'nombre' => $rowData['NOMBRE'],
                'id_destino' => $rowData['IDDESTINO'],
                'cant_noches' => $rowData['CANTNOCHES'],
                'tipo_producto' => $this->mapTipoProducto($rowData['TIPOPAQUETE']),
                'tipo_moneda' => $rowData['IZMONEDA'],
                'fecha_vigencia_desde' => $rowData['VIGENCIADESDE'],
                'fecha_vigencia_hasta' => $rowData['VIGENCIAHASTA'],
                'fecha_modificacion' => now(),
                'activo' => $rowData['RESERVAHABILITADA'],
                'pais' => 'BR',
                'ciudad' => 'RIO',
                'ciudad_iata' => $this->getIataCode('RIO'),
                'componentes' => $this->extraerComponentes($rowData['DESCRIPCION']),
                'categorias' => $this->determinarCategorias($rowData),
                'transporte' => $this->determinarTransporte($rowData['NOMBRE']),
                'usuario' => 'API Julia',
                'usuario_id' => 1
            ]
        );
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
}
