<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use SimpleXMLElement;
use App\Models\Paquete;
use App\Models\Salida;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

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
        $nuevo_paquete = Paquete::updateOrCreate(
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
'activo' => isset($paquete['activo']) && $paquete['activo'] === 'SI',
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

        foreach ($paquete['salidas'] as $salidaData) {
            if(!isset($salidaData['salida_id']))
            foreach($salidaData as $nueva_salida){

                $salida = new Salida();


        $salida->paquete_id = $nuevo_paquete->id; // Asocia el paquete creado
        $salida->salida_externo_id =  $nueva_salida['salida_id'];
        $salida->venta_online = $nueva_salida['venta_online'] == 'si'; // Convierte en booleano
        $salida->cupos = $nueva_salida['cupos'];
        $salida->info_tramos = $nueva_salida['info_tramos'] == 'si'; // Convierte en booleano


        }

        else{

$salida_externo_id = $salidaData['salida_id'];
$existe = DB::table('salidas')->where('salida_externo_id', $salida_externo_id)->exists();

if ($existe) {
    // Si ya existe un registro con el mismo `salida_externo_id`, puedes realizar una actualización
    $salida = Salida::where('salida_externo_id', $salida_externo_id)->first();
} else {
    // Si no existe, crea una nueva entrada
    $salida = new Salida();
}

$salida->paquete_id = $nuevo_paquete->id; // Asocia el paquete creado
$salida->salida_externo_id = $salida_externo_id;
$salida->venta_online = $salidaData['venta_online'] == 'si'; // Convierte en booleano
$salida->cupos = $salidaData['cupos'];
$salida->info_tramos = $salidaData['info_tramos'] == 'si'; // Convierte en booleano

// Otros campos que puedas tener
// $salida->ida_origen_fecha = ...;
// $salida->ida_origen_hora = ...;

// Guarda el registro
$salida->save();
        }


            // Guardamos la salida
        }

    }

    // Retornar respuesta con paquetes guardados
    return response()->json(['message' => 'Paquetes guardados correctamente', 'total' => count($paquetes)]);
    }
}
