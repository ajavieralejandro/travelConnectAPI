<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use SimpleXMLElement;
use XMLReader;

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
            <CustomerIp>200.126.204.4</CustomerIp>
          </GeneralParameters>
          <DepartureDate>
            <From>2025-03-02</From>
            <To>2025-10-10</To>
          </DepartureDate>
          <Rooms>
            <Room>
              <Passenger Type="ADL"/>
              <Passenger Type="ADL"/>
            </Room>
          </Rooms>
          <ArrivalDestination>AR</ArrivalDestination>
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

        // Recorrer el XML en modo streaming
        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT) {
                array_push($data, $reader->localName);  // Alternativa con función

                switch ($reader->localName) {
                    case 'Package':
                        $currentPackage = []; // Inicializar un nuevo paquete
                        break;
                    case 'Code':
                    case 'Type':
                    case 'Name':
                    case 'Nights':
                    case 'Description':
                        $currentElement = $reader->name;
                        break;
                    case 'Origin':
                        $currentElement = 'Origin';
                        $currentPackage['Origin'] = [
                            'Code' => $reader->getAttribute('Code'),
                            'City' => null, // Se completará en el siguiente paso
                        ];
                        break;
                    case 'Picture':
                        $currentElement = 'Picture';
                        if (!isset($currentPackage['Pictures'])) {
                            $currentPackage['Pictures'] = [];
                        }
                        $currentPackage['Pictures'][] = [
                            'Found' => $reader->getAttribute('Found'),
                            'Url' => null, // Se completará en el siguiente paso
                        ];
                        break;
                }
            } elseif ($reader->nodeType == XMLReader::TEXT && $currentElement) {
                switch ($currentElement) {
                    case 'Code':
                    case 'Type':
                    case 'Name':
                    case 'Nights':
                    case 'Description':
                        $currentPackage[$currentElement] = trim($reader->value);
                        break;
                    case 'Origin':
                        $currentPackage['Origin']['City'] = trim($reader->value);
                        break;
                    case 'Picture':
                        // Obtener el último índice agregado en Pictures y completar la URL
                        $lastIndex = count($currentPackage['Pictures']) - 1;
                        $currentPackage['Pictures'][$lastIndex]['Url'] = trim($reader->value);
                        break;
                }
            }

            // Cuando se cierre un Package, lo agregamos al array final
            if ($reader->nodeType == XMLReader::END_ELEMENT && $reader->name == 'Package') {
                $packages[] = $currentPackage;
            }
        }

        // Cerrar el XMLReader
        $reader->close();

        return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function xmlToArray($xmlObject) {
        $json = json_encode($xmlObject);
        return json_decode($json, true);
    }

}
