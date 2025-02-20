<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use SimpleXMLElement;

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
            <From>2025-02-13</From>
            <To>2025-04-10</To>
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
             // Convertir XML a array
             $xmlString = file_get_contents($response->getBody());
             $xmlObject = simplexml_load_string($xmlString);

             // Extraer la respuesta dentro de <Response> y decodificar entidades XML
             $responseXml = html_entity_decode($xmlObject->xpath('//Response')[0]);

             // Convertir la respuesta XML en un objeto SimpleXMLElement
             $responseObject = simplexml_load_string($responseXml);

             // Convertir el objeto a JSON
             $json = json_encode($responseObject, JSON_PRETTY_PRINT);
             dd($json);

            return response($response->getBody(), 200)
                ->header('Content-Type', 'text/xml');

            $xmlResponse = $response->getBody();
            $xmlString = file_get_contents($xmlResponse); // O la respuesta del servicio
$xml = simplexml_load_string($xmlString);
$json = json_encode($xml);
$data = json_decode($json, true);
// Acceder a los valores específicos
$currentPage = $data['Pagination']['CurrentPage'] ?? null;
$itemPerPage = $data['Pagination']['ItemPerPage'] ?? null;
$totalItems = $data['Pagination']['TotalItems'] ?? null;

return response()->json([
    'current_page' => $currentPage,
    'items_per_page' => $itemPerPage,
    'total_items' => $totalItems,
]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function xmlToArray($xmlObject) {
        $json = json_encode($xmlObject);
        return json_decode($json, true);
    }

}
