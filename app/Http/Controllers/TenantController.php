private function parseXmlResponse($xmlString)
{
    try {
        $xml = simplexml_load_string($xmlString);
        $xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xml->registerXPathNamespace('ycix', 'http://ycix.sytes.net');

        // Obtener todos los elementos Row
        $rows = $xml->xpath('//ycix:Row');

        $processedRows = [];
        foreach ($rows as $row) {
            $rowData = [
                'IDPAQUETE' => (string)$row->xpath('.//ycix:IDPAQUETE')[0],
                'NOMBRE' => (string)$row->xpath('.//ycix:NOMBRE')[0],
                'IDDESTINO' => (string)$row->xpath('.//ycix:IDDESTINO')[0],
                'CANTNOCHES' => (string)$row->xpath('.//ycix:CANTNOCHES')[0],
                'TIPOPAQUETE' => (string)$row->xpath('.//ycix:TIPOPAQUETE')[0],
                'IZMONEDA' => (string)$row->xpath('.//ycix:IZMONEDA')[0],
                'VIGENCIADESDE' => (string)$row->xpath('.//ycix:VIGENCIADESDE')[0],
                'VIGENCIAHASTA' => (string)$row->xpath('.//ycix:VIGENCIAHASTA')[0],
                'EXPORTA' => (string)$row->xpath('.//ycix:EXPORTA')[0],
                'DESCRIPCION' => (string)$row->xpath('.//ycix:DESCRIPCION')[0],
                'RESERVAHABILITADA' => (string)$row->xpath('.//ycix:RESERVAHABILITADA')[0],
                '_MS' => (string)$row->xpath('.//ycix:_MS')[0]
            ];

            // Limpiar formato RTF de la descripción
            $rowData['DESCRIPCION'] = $this->cleanRtf($rowData['DESCRIPCION']);

            $processedRows[] = $rowData;
        }

        $result = [
            'data' => [
                [
                    'DocumentElement' => [
                        'Row' => $processedRows
                    ]
                ]
            ]
        ];

        return response()->json($result);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error procesando la respuesta XML',
            'message' => $e->getMessage()
        ], 500);
    }
}

private function cleanRtf($rtfText)
{
    // Eliminar comandos RTF básicos y mantener texto plano
    $cleanText = preg_replace('/\\\\([a-z]{1,})(-?\d{1,})? */i', '', $rtfText);
    $cleanText = preg_replace('/\{\\\*?\\\'[0-9a-f]{2}\}/i', '', $cleanText);
    $cleanText = str_replace(['\\par', '\\pard', '{', '}'], "\n", $cleanText);
    $cleanText = html_entity_decode($cleanText);
    $cleanText = trim(preg_replace('/\s+/', ' ', $cleanText));

    return $cleanText;
}
