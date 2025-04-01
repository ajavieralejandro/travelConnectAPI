<?php
namespace App\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Paquete;
use Carbon\Carbon;
use Exception;
use SimpleXMLElement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Http;
class JuliaServiceProvider
{
    protected $client;
    protected $url;
    protected $soapAction;

    public function __construct()
    {
        $this->client = new Client(['timeout' => 300]);
        $this->url = 'http://ycixweb.juliatours.com.ar/WSJULIADEMO/WSJULIA.asmx';
        $this->soapAction = 'http://ycix.sytes.net/WS_jw_PAQUETES_CABECERA';
    }

    public function getPaquetes(string $xml)
    {
        try {
            $response = $this->client->post($this->url, [
                'headers' => [
                    'Content-Type' => 'text/xml; charset=utf-8',
                    'SOAPAction' => $this->soapAction
                ],
                'body' => $xml
            ]);

            $xmlResponse = $response->getBody()->getContents();
            Log::debug('Raw XML Response:', ['xml' => $xmlResponse]);
            return $this->processXmlResponse($xmlResponse);

        } catch (RequestException $e) {
            Log::error('SOAP Request Error:', ['error' => $e->getMessage()]);
            return [
                'error' => 'SOAP Request Failed',
                'message' => $e->getMessage()
            ];
        }
    }

    private function processXmlResponse(string $xmlResponse)
    {
        try {
            $xml = simplexml_load_string($xmlResponse, "SimpleXMLElement", LIBXML_NOCDATA);
            return $this->processRows(json_decode(json_encode($xml), true));
        } catch (Exception $e) {
            Log::error('XML Processing Error:', ['error' => $e->getMessage()]);
            return [
                'error' => 'Processing Error',
                'message' => $e->getMessage()
            ];
        }
    }

    private function processRows(array $rows): array
    {
        $processed = [];
        $rows = $rows['Row'] ?? [];
        foreach ($rows as $row) {
            try {
                $processed[] = $this->savePackage($row);
            } catch (Exception $e) {
                Log::error('Error processing row:', ['error' => $e->getMessage()]);
            }
        }
        return $processed;
    }

    private function savePackage(array $rowData)
    {
        return Paquete::updateOrCreate(
            ['paquete_externo_id' => $rowData['IDPAQUETE'] . '_julia'],
            [
                'titulo' => $rowData['NOMBRE'],
                'id_destino' => $rowData['IDDESTINO'] ?? null,
                'cant_noches' => (int)($rowData['CANTNOCHES'] ?? 0),
                'tipo_producto' => $this->mapTipoProducto($rowData['TIPOPAQUETE'] ?? '0'),
                'tipo_moneda' => $rowData['IZMONEDA'] ?? 'USD',
                'fecha_vigencia_desde' => Carbon::parse($rowData['VIGENCIADESDE']),
                'fecha_vigencia_hasta' => Carbon::parse($rowData['VIGENCIAHASTA']),
                'activo' => ($rowData['RESERVAHABILITADA'] ?? 'F') === 'V',
                'pais' => 'BR',
                'ciudad' => 'RIO',
                'ciudad_iata' => $this->getIataCode('RIO'),
                'componentes' => $this->extraerComponentes($rowData['DESCRIPCION'] ?? ''),
                'categorias' => $this->determinarCategorias($rowData),
                'transporte' => $this->determinarTransporte($rowData['NOMBRE'] ?? ''),
                'usuario' => 'Julia',
                'usuario_id' => 1
            ]
        );
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
        $limpio = strtoupper(strip_tags($descripcion));
        $componentes = [];
        if (str_contains($limpio, 'TRASLADO')) $componentes[] = 'Traslados';
        if (str_contains($limpio, 'HOTEL')) $componentes[] = 'Alojamiento';
        if (str_contains($limpio, 'EXCURSION')) $componentes[] = 'Excursiones';
        return array_unique($componentes);
    }

    private function determinarCategorias(array $rowData): array
    {
        $categorias = [];
        if (($rowData['CANTNOCHES'] ?? 0) > 7) $categorias[] = 'LargaEstadia';
        if (($rowData['RESERVAHABILITADA'] ?? 'F') === 'V') $categorias[] = 'ReservaInmediata';
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

    public function enviarPaquetes( $request)
    {
        // URL del servicio SOAP
        $url = 'http://ycixweb.juliatours.com.ar/WSJULIADEMO/WSJULIA.asmx/WS_jw_PAQUETES_CABECERA';

        // Datos a enviar
        $origenCodigo = $this->obtenerCodigoPorOrigen($request->origen)?->codigo ?? '';
        $destinoCodigos = $this->obtenerCodigosPorDestino($request->destino);

        $destinoPais = $destinoCodigos->codigo_pais ?? '';
        $destinoCiudad = $destinoCodigos->codigo_ciudad ?? '';
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

        try {
            // Hacer la solicitud POST
            $response = Http::asForm()->post($url, $data);
            $xmlResponse = $response->body();

            if ($response->successful()) {
                return $this->processXmlResponse($xmlResponse);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => $response->status(),
                    'message' => $response->body(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'exception',
                'message' => $e->getMessage(),
            ], 500);
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

}
