<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use SimpleXMLElement;
use XMLReader;
use DOMDocument;
use App\Models\Paquete;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OlaServiceProvider  extends ServiceProvider
{
    protected $client;
    protected $soapUrl = "https://aws-qa1.ola.com.ar/qa/wsola/endpoint";

    public function __construct()
    {
        $this->client = new Client();
    }

    public function register()
{
    $this->app->singleton('ola', function ($app) {
        return new OlaService(); // Asumiendo que OlaService es otra clase
    });
}

    public function fetchPackageData($fechaDesde, $fechaHasta, $origen, $destino)
    {
        $xmlRequest = $this->buildSoapRequest($fechaDesde, $fechaHasta, $origen, $destino);

        try {
            $response = $this->client->post($this->soapUrl, [
                'headers' => [
                    'Content-Type' => 'text/xml; charset=utf-8',
                    'SOAPAction' => 'http://aws-qa1.ola.com.ar/qa/wsola/endpoint#GetPackagesFares',
                ],
                'body' => $xmlRequest,
            ]);

            return $this->processSoapResponse($response->getBody());

        } catch (\Exception $e) {
            throw new \Exception("SOAP request failed: " . $e->getMessage());
        }
    }

    protected function buildSoapRequest($fechaDesde, $fechaHasta, $origen, $destino)
    {
        return <<<XML
        <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
                           xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                           xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
                           xmlns:tns="http://aws-qa1.ola.com.ar/qa/wsola/endpoint"
                           SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
          <SOAP-ENV:Body>
            <tns:GetPackagesFares xmlns:tns="http://aws-qa1.ola.com.ar/qa/wsola/endpoint">
              <Request xsi:type="xsd:string"><![CDATA[
              <GetPackagesFaresRequest>
          <GeneralParameters>
            <Username>BUETRIPNOWWEB</Username>
            <Password>e3fab5ef81210da49bee83c32bce283ebcb19dfa8b27596130959a3a6fa55232</Password>
            <CustomerIp>181.228.60.154</CustomerIp>
          </GeneralParameters>
          <DepartureDate>
            <From>$fechaDesde</From>
            <To>$fechaHasta</To>
          </DepartureDate>
          <Rooms>
            <Room>
              <Passenger Type="ADL"/>
              <Passenger Type="ADL"/>
            </Room>
          </Rooms>
          <DepartureDestination>$origen</DepartureDestination>
          <ArrivalDestination>$destino</ArrivalDestination>
          <FareCurrency>ARS</FareCurrency>
          <Outlet>1</Outlet>
          <PackageType>ALL</PackageType>
        </GetPackagesFaresRequest>
              ]]></Request>
            </tns:GetPackagesFares>
          </SOAP-ENV:Body>
        </SOAP-ENV:Envelope>
        XML;
    }

    protected function processSoapResponse($xmlContent)
    {
        $reader = new XMLReader();
        $reader->XML($xmlContent);

        $packages = [];

        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT
                && $reader->localName == 'GetPackagesFaresResponse'
                && $reader->namespaceURI == 'http://aws-qa1.ola.com.ar/qa/wsola/endpoint') {

                $node = $reader->expand();
                $dom = new DOMDocument();
                $domNode = $dom->importNode($node, true);
                $dom->appendChild($domNode);

                $xml = simplexml_import_dom($dom);
                $innerXmlString = (string)$xml->Response;
                $innerXml = simplexml_load_string($innerXmlString);

                foreach ($innerXml->PackageFare as $package) {
                    $arrayData = $this->xmlToArray($package);
                    $packages[] = $this->mapToPaqueteModel($arrayData);
                }

                break;
            }
        }

        $reader->close();
        return $packages;
    }

    protected function xmlToArray($xmlObject)
    {
        $json = json_encode($xmlObject);
        return json_decode($json, true);
    }

    public function obtenerCodigosPorDestino($destino) {
        if (!$destino) {
            return null;
        }

        // Extraer la ciudad del destino ("CIUDAD - PAÍS" → "CIUDAD")
        $ciudadPrincipal = trim(explode(' - ', $destino)[0]);

        $response =  DB::table('destinos_ola')
            ->select('codigo_iata')
            ->where(function ($query) use ($ciudadPrincipal) {

                $query->where('nombre_pais', 'like', "%{$ciudadPrincipal}%")
                    ->orWhere('nombre_ciudad', 'like', "%{$ciudadPrincipal}%")
                    ->orWhere('codigo_ciudad', 'like', "%{$ciudadPrincipal}%");
            })
            ->first();
            return $response->codigo_iata;

    }

    public function mapToPaqueteModel(array $datosExternos)
    {
        $codigoPaquete = isset($datosExternos['Package']['Code']) ? $datosExternos['Package']['Code'] . '_ola' : null;

        return Paquete::updateOrCreate(
            ['paquete_externo_id' => $codigoPaquete],
            [
                'fecha_modificacion' => now(),
                'usuario' => 'Ola',
                'usuario_id' => null,
                'pais' => 'Argentina',
                'ciudad' => $datosExternos['Package']['Name'] ?? null,
                'ciudad_iata' => 'SLA',
                'fecha_vigencia_desde' => isset($datosExternos['Flight']['VencimientoEmision'])
                    ? Carbon::parse($datosExternos['Flight']['VencimientoEmision'])
                    : null,
                'fecha_vigencia_hasta' => isset($datosExternos['Flight']['VencimientoNomina'])
                    ? Carbon::parse($datosExternos['Flight']['VencimientoNomina'])
                    : null,
                'titulo' => $datosExternos['Package']['Name'] ?? null,
                'cant_noches' => $datosExternos['Package']['Nights'] ?? 0,
                'tipo_producto' => $datosExternos['Package']['Type'] ?? 'Paquete estándar',
                'componentes' => [
                    'vuelo' => [
                        'aerolinea' => $datosExternos['Flight']['Supplier']['Name'] ?? null,
                        'numero_vuelo' => $datosExternos['Flight']['Trips']['Trip'][0]['Segments']['Segment']['FlightNumber'] ?? null,
                        'clase' => $datosExternos['Flight']['Trips']['Trip'][0]['Segments']['Segment']['FlightClass'] ?? null,
                        'fecha_salida' => $datosExternos['Flight']['Trips']['Trip'][0]['DepartureDate'] ?? null,
                        'fecha_regreso' => $datosExternos['Flight']['Trips']['Trip'][1]['DepartureDate'] ?? null,
                    ],
                    'hotel' => [
                        'nombre' => $datosExternos['Descriptions']['Description']['Name'] ?? null,
                        'categoria' => $datosExternos['Descriptions']['Description']['HotelClass'] ?? null,
                        'tipo_habitacion' => $datosExternos['Descriptions']['Description']['FareDescriptions']['FareDescription'][0] ?? null,
                        'regimen' => $datosExternos['Descriptions']['Description']['FareDescriptions']['FareDescription'][1] ?? null,
                    ],
                    'traslados' => [
                        'llegada' => $datosExternos['Paxs']['Pax'][0]['FareComponents']['FareComponent'][2]['Name'] ?? null,
                        'salida' => $datosExternos['Paxs']['Pax'][0]['FareComponents']['FareComponent'][3]['Name'] ?? null,
                    ],
                    'excursiones' => [
                        $datosExternos['Paxs']['Pax'][0]['FareComponents']['FareComponent'][4]['Name'] ?? null,
                    ],
                ],
                'categorias' => [],
                'tipo_moneda' => $datosExternos['FareTotal']['Currency'] ?? 'ARS',
                'activo' => true,
                'imagen_principal' => $datosExternos['Descriptions']['Description']['Pictures']['Picture'][0] ?? null,
                'galeria_imagenes' => $datosExternos['Descriptions']['Description']['Pictures']['Picture'] ?? [],
                'edad_menores' => 12,
                'transporte' => 'Aéreo',
                'hoteles' => [
                    [
                        'nombre' => $datosExternos['Descriptions']['Description']['Name'] ?? null,
                        'categoria' => $datosExternos['Descriptions']['Description']['HotelClass'] ?? null,
                        'direccion' => null,
                        'imagenes' => $datosExternos['Descriptions']['Description']['Pictures']['Picture'] ?? [],
                    ]
                ],
                'descripcion' => $datosExternos['Descriptions']['Description']['Description'] ?? '',
                'descuento' => 0.00,
            ]
        );
    }
}