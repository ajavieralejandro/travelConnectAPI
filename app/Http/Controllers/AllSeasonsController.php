<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use SimpleXMLElement;
use App\Models\Paquete;
use Illuminate\Support\Facades\Http;

class AllSeasonsController extends Controller
{



    public function getSeasons()
    {
          // URL del XML
    $xmlUrl = "https://travel-tool.net/admin/xml/allseasons.xml";

    // Descargar XML
    $response = Http::get($xmlUrl);
    if ($response->failed()) {
        return response()->json(['error' => 'No se pudo obtener el XML'], 500);
    }

    // Convertir XML a array
    $xml = new SimpleXMLElement($response->body());
    $json = json_encode($xml);
    $paquetesArray = json_decode($json, true);

    // 🔥 Corrección aquí: acceder a 'paquetes' en lugar de 'paquete'
    if (!isset($paquetesArray['paquetes']['paquete']) || empty($paquetesArray['paquetes']['paquete'])) {
        return response()->json(['error' => 'No se encontraron paquetes en el XML'], 404);
    }

    // Obtener los paquetes
    $paquetes = $paquetesArray['paquetes']['paquete'];

    // Asegurar que 'paquete' sea un array de paquetes
    if (!is_array($paquetes) || isset($paquetes['paquete_externo_id'])) {
        $paquetes = [$paquetes];
    }


    foreach ($paquetes as $paquete) {
        // Extraer destinos
        $destinos = $paquete['destinos']['destino'] ?? null;
        $pais = $destinos['pais'] ?? null;
        $ciudad = $destinos['ciudad'] ?? null;
        $ciudadIATA = $destinos['ciudadIATA'] ?? null;

        // Asegurarse de que los valores sean cadenas
        $pais = (string) $pais;
        $ciudad = (string) $ciudad;
// Asegúrate de que el valor sea un string, o toma el primer valor si es un array.
$ciudadIATA = is_array($ciudadIATA) ? (isset($ciudadIATA[0]) ? (string)$ciudadIATA[0] : '') : (string)$ciudadIATA;

        // Obtener componentes como string (ejemplo: "3,1")
        $componentesArray = $paquete['componentes']['componente'] ?? [];
        $componentes = is_array($componentesArray) ? implode(',', $componentesArray) : (string) $componentesArray;

        // Extraer categorías (puede haber varias categorías)
        $categoriasArray = $paquete['categorias']['categoria'] ?? [];
        $categorias = is_array($categoriasArray) ? implode(',', array_column($categoriasArray, 'categoria_id')) : (string) $categoriasArray;

        // Guardar en la base de datos
        Paquete::updateOrCreate(
            ['paquete_externo_id' => $paquete['paquete_externo_id']],
            [
                'fecha_modificacion' => $paquete['fecha_modificacion'] ?? null,
                'usuario' => $paquete['usuario'] ?? null,
                'usuario_id' => $paquete['usuario_id'] ?? null,
                'fecha_vigencia_desde' => $paquete['fecha_vigencia_desde'] ?? null,
                'fecha_vigencia_hasta' => $paquete['fecha_vigencia_hasta'] ?? null,
                'fecha_desde' => $paquete['fecha_desde'] ?? null,
'fecha_hasta' => $paquete['fecha_hasta'] ?? null,
                'tipo_producto' => $paquete['tipo_producto'] ?? null,
                'cant_noches' => $paquete['cant_noches'] ?? null,
                'tipo_moneda' => $paquete['tipo_moneda'] ?? null,
                'activo' => $paquete['activo'] ?? null,
                'imagen_principal' => $paquete['imagen_principal'] ?? null,
                'edad_menores' => $paquete['edad_menores'] ?? null,
                'transporte' => $paquete['transporte'] ?? null,
                'descuento' => $paquete['descuento'] ?? null,
                'pais' => $pais,
                'ciudad' => $ciudad,
                'ciudad_iata' => $ciudadIATA,
                'componentes' => $componentes,
                'categorias' => $categorias,
            ]
        );
    }

    // Retornar respuesta con paquetes guardados
    return response()->json(['message' => 'Paquetes guardados correctamente', 'total' => count($paquetes)]);
    }
}
