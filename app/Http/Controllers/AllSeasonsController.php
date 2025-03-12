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

    private function guardarSalida($nuevo_paquete,$nueva_salida){


        $salida_externo_id = $nueva_salida['salida_id'];
        $existe = DB::table('salidas')->where('salida_externo_id', $salida_externo_id)->exists();
        $salida = null;
        if ($existe) {
            // Si ya existe un registro con el mismo `salida_externo_id`, puedes realizar una actualización
            $salida = Salida::where('salida_externo_id', $salida_externo_id)->first();
        } else {
            // Si no existe, crea una nueva entrada
            $salida = new Salida();
        }

        $salida->paquete_id = $nuevo_paquete->id;
        $salida->salida_externo_id = $nueva_salida['salida_id'] ?? null;
        $salida->venta_online = isset($nueva_salida['venta_online']) ? ($nueva_salida['venta_online'] == 'si') : false;
        $salida->cupos = $nueva_salida['cupos'] ?? 0;
        $salida->info_tramos = isset($nueva_salida['info_tramos']) ? ($nueva_salida['info_tramos'] == 'si') : false;
        $salida->fecha_desde = $this->computarFecha($nueva_salida['fecha_desde']);
        $salida->fecha_hasta = $this->computarFecha($nueva_salida['fecha_hasta']);
        $salida->fecha_viaje = $this->computarFecha($nueva_salida['fecha_viaje']);
        $salida->ida_origen_fecha = $this->computarFecha($nueva_salida['ida_origen_fecha']);
        $salida->ida_origen_hora = $this->computarFecha($nueva_salida['ida_origen_hora']);
        $salida->ida_origen_ciudad = $nueva_salida['ida_origen_ciudad'];
        $salida->ida_destino_fecha = $this->computarFecha($nueva_salida['ida_destino_fecha']);
        $salida->ida_destino_hora = $this->computarFecha($nueva_salida['ida_destino_hora']);
        $salida->ida_destino_ciudad = $nueva_salida['ida_destino_ciudad'];
        $salida->ida_clase_vuelo = $nueva_salida['ida_clase_vuelo'];
        $salida->ida_linea_aerea = $nueva_salida['ida_linea_aerea'];
        $salida->ida_vuelo = $nueva_salida['ida_vuelo'];
        $salida->ida_escalas = $nueva_salida['ida_escalas'];
        $salida->vuelta_origen_fecha = $this->computarFecha($nueva_salida['vuelta_origen_fecha']);
        $salida->vuelta_origen_hora = $this->computarFecha($nueva_salida['vuelta_origen_hora']);
        $salida->vuelta_origen_ciudad = $nueva_salida['vuelta_origen_ciudad'];
        $salida->vuelta_destino_fecha = $this->computarFecha($nueva_salida['vuelta_destino_fecha']);
        $salida->vuelta_destino_hora = $this->computarFecha($nueva_salida['vuelta_destino_hora']);
        $salida->vuelta_destino_ciudad = $nueva_salida['vuelta_destino_ciudad'];
        $salida->vuelta_clase_vuelo = $nueva_salida['vuelta_clase_vuelo'];
        $salida->vuelta_linea_aerea = $nueva_salida['vuelta_linea_aerea'];
        $salida->vuelta_vuelo = $nueva_salida['vuelta_vuelo'];
        $salida->vuelta_escalas = $nueva_salida['vuelta_escalas'];

        $salida->single_precio = $nueva_salida['single_precio'] ?? null;
        $salida->single_impuesto = $nueva_salida['single_impuesto'] ?? null;
        $salida->single_otro = $nueva_salida['single_otro'] ?? null;
        $salida->single_otro2 = $nueva_salida['single_otro2'] ?? null;

        $salida->doble_precio = $nueva_salida['doble_precio'] ?? null;
        $salida->doble_impuesto = $nueva_salida['doble_impuesto'] ?? null;
        $salida->doble_otro = $nueva_salida['doble_otro'] ?? null;
        $salida->doble_otro2 = $nueva_salida['doble_otro2'] ?? null;

        $salida->triple_precio = $nueva_salida['triple_precio'] ?? null;
        $salida->triple_impuesto = $nueva_salida['triple_impuesto'] ?? null;
        $salida->triple_otro = $nueva_salida['triple_otro'] ?? null;
        $salida->triple_otro2 = $nueva_salida['triple_otro2'] ?? null;

        $salida->cuadruple_precio = $nueva_salida['cuadruple_precio'] ?? null;
        $salida->cuadruple_impuesto = $nueva_salida['cuadruple_impuesto'] ?? null;
        $salida->cuadruple_otro = $nueva_salida['cuadruple_otro'] ?? null;
        $salida->cuadruple_otro2 = $nueva_salida['cuadruple_otro2'] ?? null;

        // Precios familiares
        $salida->familia_1_precio = $nueva_salida['familia_1_precio'] ?? null;
        $salida->familia_1_impuesto = $nueva_salida['familia_1_impuesto'] ?? null;
        $salida->familia_1_otro = $nueva_salida['familia_1_otro'] ?? null;
        $salida->familia_1_otro2 = $nueva_salida['familia_1_otro2'] ?? null;

        $salida->familia_2_precio = $nueva_salida['familia_2_precio'] ?? null;
        $salida->familia_2_impuesto = $nueva_salida['familia_2_impuesto'] ?? null;
        $salida->familia_2_otro = $nueva_salida['familia_2_otro'] ?? null;
        $salida->familia_2_otro2 = $nueva_salida['familia_2_otro2'] ?? null;

        // Campo adicional de vuelta_escalas
        $salida->vuelta_escalas = $nueva_salida['vuelta_escalas'] ?? null;


        $salida->save();

    }


    private function computarFecha($fecha){
        //Si la fecha es un arreglo vacio entonces es nula
        if(is_array($fecha))
            {
                if(count($fecha)>0)
                    return $fecha[0];
                else
                    return null;

            }
        return $fecha;
    }

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

        //Guardo las salidas asociadas a los paquetes
        foreach ($paquete['salidas'] as $salidaData) {
            if(!isset($salidaData['salida_id']))
            foreach($salidaData as $nueva_salida){
                $this->guardarSalida($nuevo_paquete,$nueva_salida);
            }
            else
                $this->guardarSalida($nuevo_paquete,$salidaData);
        }

    }

    // Retornar respuesta con paquetes guardados
    return response()->json(['message' => 'Paquetes guardados correctamente', 'total' => count($paquetes)]);
    }



}
