<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paquete;
use App\Models\PaqueteJulia;
use Carbon\Carbon;

class PaquetesController extends Controller
{
    //
    public function index()
    {
        $paquetes = Paquete::paginate(50);
        $tarjetasJulia =[];
        return view('paquetes.index', compact('paquetes','tarjetasJulia'));
    }

    public function getPaquetes(){
        $paquetes = Paquete::select(
            'nombre',
            'fecha_desde',
            'fecha_hasta',
            'pais',
            'ciudad',
            'imagen_principal',
            'single_precio', 'single_impuesto', 'single_otro', 'single_otro2',
            'doble_precio', 'doble_impuesto', 'doble_otro', 'doble_otro2',
            'triple_precio', 'triple_impuesto', 'triple_otro', 'triple_otro2',
            'cuadruple_precio', 'cuadruple_impuesto', 'cuadruple_otro', 'cuadruple_otro2'
        )->paginate(30);

        // Formateamos la respuesta para agrupar los precios
        $paquetesFormateados = $paquetes->map(function ($paquete) {
            return [
                'nombre' => $paquete->nombre,
                'fecha_desde' => $paquete->fecha_desde,
                'fecha_hasta' => $paquete->fecha_hasta,
                'pais' =>$paquete->pais,
                'ciudad'=>$paquete->ciudad,
                'imagen'=>$paquete->imagen_principal,
                'precios' => [
                    'single' => [
                        'precio' => $paquete->single_precio,
                        'impuesto' => $paquete->single_impuesto,
                        'otro' => $paquete->single_otro,
                        'otro2' => $paquete->single_otro2,
                    ],
                    'doble' => [
                        'precio' => $paquete->doble_precio,
                        'impuesto' => $paquete->doble_impuesto,
                        'otro' => $paquete->doble_otro,
                        'otro2' => $paquete->doble_otro2,
                    ],
                    'triple' => [
                        'precio' => $paquete->triple_precio,
                        'impuesto' => $paquete->triple_impuesto,
                        'otro' => $paquete->triple_otro,
                        'otro2' => $paquete->triple_otro2,
                    ],
                    'cuadruple' => [
                        'precio' => $paquete->cuadruple_precio,
                        'impuesto' => $paquete->cuadruple_impuesto,
                        'otro' => $paquete->cuadruple_otro,
                        'otro2' => $paquete->cuadruple_otro2,
                    ],
                ]
            ];
        });

        return response()->json($paquetesFormateados->toArray());
    }
    public function obtenerPaquetesPorDestino(Request $request)
{
    // Obtener los parámetros de destino desde la solicitud (Request)
    $pais = $request->input('pais');
    $ciudad = $request->input('ciudad');
    $ciudadIATA = $request->input('ciudad_iata');

    // Iniciar la consulta base para obtener los paquetes
    $query = Paquete::query();

    // Filtrar por país si está presente
    if ($pais) {
        $query->where('pais', 'like', '%' . $pais . '%');
    }

    // Filtrar por ciudad si está presente
    if ($ciudad) {
        $query->where('ciudad', 'like', '%' . $ciudad . '%');
    }

    // Filtrar por ciudad_iata si está presente
    if ($ciudadIATA) {
        $query->where('ciudad_iata', 'like', '%' . $ciudadIATA . '%');
    }

    // Obtener los paquetes que cumplen con los filtros
    $paquetes = $query->get();

    // Verificar si se encontraron paquetes
    if ($paquetes->isEmpty()) {
        return response()->json(['message' => 'No se encontraron paquetes con los filtros proporcionados.'], 404);
    }

    // Devolver los paquetes encontrados en formato JSON
    return response()->json($paquetes);
}

public function buscarPaquetes(Request $request)
{
     // Obtener los parámetros de la solicitud
     $destino = $request->input('destino');
     $fechaDesde = $request->input('fecha_desde');
     $fechaHasta = $request->input('fecha_hasta');
     $cantidadPasajeros = $request->input('cantidad_pasajeros');
     // Iniciar la consulta base para obtener los paquetes
     $query = Paquete::query();

     // Filtrar por destino (país o ciudad)
     if ($destino) {
         $query->where(function ($q) use ($destino) {
             $q->where('pais', 'like', '%' . $destino . '%')
               ->orWhere('ciudad', 'like', '%' . $destino . '%');
         });
     }

/*if ($fechaDesde) {
    // Asegúrate de que la fecha esté en formato Carbon
    $fechaDesde = Carbon::parse($fechaDesde);

    $query->where('fecha_vigencia_desde', '>=', $fechaDesde);
}*/
     /*
     // Filtrar por fechas si están presentes

     if ($fechaHasta) {
         $query->where('fecha_vigencia_hasta', '<=', $fechaHasta);
     }

     // Filtrar por cantidad de pasajeros dentro de 'componentes' (formato JSON)
     if ($cantidadPasajeros) {
         $query->whereJsonContains('componentes->pasajeros', (int) $cantidadPasajeros);
     }*/

     // Obtener los paquetes que cumplen con los filtros
     $paquetes = $query->get();

     // Verificar si se encontraron paquetes
     if ($paquetes->isEmpty()) {
         return response()->json(['message' => 'No se encontraron paquetes con los filtros proporcionados.'], 404);
     }
     $tarjetasJulia = [];
     // Devolver los paquetes encontrados en formato JSON
     return view('paquetes.index', compact('paquetes','tarjetasJulia'));
    }


}
