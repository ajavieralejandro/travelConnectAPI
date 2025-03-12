<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use SimpleXMLElement;
use XMLReader;
use DOMDocument;

class SoapController extends Controller
{
    public function sendSoapRequest()
    {
        // Definir la URL del servicio SOAP
        $url = "https://aws-qa1.ola.com.ar/qa/wsola/endpoint";

        // Definir el XML de la solicitud
        $xmlRequest = <<<XML
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
            <CustomerIp>181.231.247.65</CustomerIp>
          </GeneralParameters>
          <DepartureDate>
            <From>2025-04-01</From>
            <To>2025-04-30</To>
          </DepartureDate>
          <Rooms>
            <Room>
              <Passenger Type="ADL"/>
              <Passenger Type="ADL"/>
            </Room>
          </Rooms>
          <DepartureDestination>BUE</DepartureDestination>
          <ArrivalDestination>SLA</ArrivalDestination>
          <FareCurrency>ARS</FareCurrency>
          <Outlet>1</Outlet>
          <PackageType>ALL</PackageType>
        </GetPackagesFaresRequest>
              ]]></Request>
            </tns:GetPackagesFares>
          </SOAP-ENV:Body>
        </SOAP-ENV:Envelope>
        XML;

        try {
            // Crear cliente HTTP
            $client = new Client();

            // Hacer la petición SOAP
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'text/xml; charset=utf-8',
                    'SOAPAction' => 'http://aws-qa1.ola.com.ar/qa/wsola/endpoint#GetPackagesFares',
                ],
                'body' => $xmlRequest,
            ]);
             // Obtener el XML desde la request
        $xmlContent = $response->getBody();
        // Crear un XMLReader

        $reader = new XMLReader();
        $reader->XML($xmlContent);

        $packages = [];
        $flights = [];
        $currentElement = null;
        // Recorrer el XML en modo streaming
        $packages = [];
        $currentPackage = [];
        $currentElement = null;
        $data = [];

        $packageFares = [];

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
                // Ejemplo de extracción de datos
                $packageFares = [
                    'prices' => [
                        'min' => (string)$xml->Summary->Prices->Min,
                        'max' => (string)$xml->Summary->Prices->Max,
                        'currency' => (string)$xml->Summary->Prices['Currency']
                    ],
                    'flights' => [],
                    'hotels' => []
                ];

                // Procesar vuelos
                foreach ($xml->PackageFare->Flight->Trips->Trip as $trip) {
                    $packageFares['flights'][] = [
                        'departure' => (string)$trip->DepartureCity,
                        'arrival' => (string)$trip->ArrivalCity,
                        'date' => (string)$trip->DepartureDate
                    ];
                }

                // Procesar hoteles
                foreach ($xml->PackageFare->Descriptions->Description as $desc) {
                    if ((string)$desc->Type == 'HOTEL') {
                        $packageFares['hotels'][] = [
                            'name' => (string)$desc->Name,
                            'nights' => (int)$desc->Nights,
                            'class' => (int)$desc->HotelClass
                        ];
                    }
                }

                break;
            }
        }

        $reader->close();

        // Usar $packageFares en tu lógica
        dd($packageFares);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function xmlToArray($xmlObject) {
        $json = json_encode($xmlObject);
        return json_decode($json, true);
    }

    public function parsePackageFares(XMLReader $reader)
    {

        $result = [
            'package' => [],
            'flight' => [],
            'hotel' => [],
            'prices' => [],
            'taxes' => [],
            'cancellation_policies' => []
        ];

        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT) {
                // Manejar namespaces
                $nodeName = $reader->localName;

                switch ($nodeName) {
                    case 'GetPackagesFaresResponse':
                        $this->parseGetPackagesFaresResponse($reader, $result);
                        break;
                }
            }
        }

        $reader->close();

        return response()->json($result);

    }
    private function parseGetPackagesFaresResponse($reader, &$result)
    {
        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT) {
                $nodeName = $reader->localName;

                switch ($nodeName) {
                    case 'PackageFare':
                        $this->parsePackageFare($reader, $result);
                        break;

                    case 'Prices':
                        if ($reader->getAttribute('Currency') == 'ARS') {
                            $result['prices'] = [
                                'min' => $this->readNextValue($reader, 'Min'),
                                'max' => $this->readNextValue($reader, 'Max')
                            ];
                        }
                        break;
                }
            }
        }
    }

    private function parsePackageFare($reader, &$result)
    {
        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT) {
                $nodeName = $reader->localName;

                switch ($nodeName) {
                    case 'Code':
                        $result['package']['code'] = $reader->readString();
                        break;

                    case 'Nights':
                        $result['package']['nights'] = $reader->readString();
                        break;

                    case 'Flight':
                        $this->parseFlight($reader, $result);
                        break;

                    case 'Description':
                        if ($reader->getAttribute('Type') == 'HOTEL') {
                            $result['hotel']['name'] = $this->readNextValue($reader, 'Name');
                            $result['hotel']['class'] = $this->readNextValue($reader, 'HotelClass');
                        }
                        break;

                    case 'Tax':
                        $result['taxes'][] = [
                            'name' => $this->readNextValue($reader, 'Name'),
                            'value' => $this->readNextValue($reader, 'Value')
                        ];
                        break;

                    case 'Policy':
                        $result['cancellation_policies'][] = [
                            'from' => $reader->getAttribute('From'),
                            'to' => $reader->getAttribute('To'),
                            'amount' => $reader->readString()
                        ];
                        break;
                }
            }

            if ($reader->nodeType == XMLReader::END_ELEMENT && $reader->localName == 'PackageFare') {
                break;
            }
        }
    }

    private function parseFlight($reader, &$result)
    {
        $flight = [];

        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT) {
                $nodeName = $reader->localName;

                switch ($nodeName) {
                    case 'Code':
                        $flight['code'] = $reader->readString();
                        break;

                    case 'DepartureDate':
                        $flight['departure_date'] = $reader->readString();
                        break;

                    case 'DepartureAirport':
                        $flight['departure_airport'] = $reader->getAttribute('Iata');
                        break;
                }
            }

            if ($reader->nodeType == XMLReader::END_ELEMENT && $reader->localName == 'Flight') {
                $result['flight'] = $flight;
                break;
            }
        }
    }

    private function readNextValue($reader, $tagName)
    {
        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT && $reader->localName == $tagName) {
                return $reader->readString();
            }
        }
        return null;
    }
}


