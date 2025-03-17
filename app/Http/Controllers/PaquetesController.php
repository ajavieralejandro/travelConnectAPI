<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paquete;
use App\Models\Salida;

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
        $paquetes = Paquete::with(['salidas' => function ($query) {
            $query->select(
                'id', 'paquete_id', 'fecha_desde', 'fecha_hasta',
                'single_precio', 'single_impuesto', 'single_otro', 'single_otro2',
                'doble_precio', 'doble_impuesto', 'doble_otro', 'doble_otro2',
                'triple_precio', 'triple_impuesto', 'triple_otro', 'triple_otro2',
                'cuadruple_precio', 'cuadruple_impuesto', 'cuadruple_otro', 'cuadruple_otro2'
            );
        }])->get();

        // Convertir a array
        $paquetesArray = $paquetes->toArray();

        return response()->json($paquetesArray);}
        public function obtenerPaquetesPorDestino(Request $request)
{
    $query = Salida::query();

    // 1. Filtros en Salidas
    if ($request->filled('fechaSalida')) {
        $fechaSalida = Carbon::parse(preg_replace('/(GMT.*)/', '', $request->fechaSalida));
        $query->whereDate('fecha_desde', '>', $fechaSalida->toDateString());
    }

    if ($request->filled('viajeros')) {
        $campoPrecio = match ((int)$request->viajeros) {
            1 => 'single_precio',
            2 => 'doble_precio',
            3 => 'triple_precio',
            4 => 'cuadruple_precio',
            default => null
        };

        if ($campoPrecio) {
            $query->where($campoPrecio, '>', 0);
        }
    }

    // 2. Filtros en Paquete (relación)
    if ($request->filled('ciudadOrigen')) {
        $query->whereHas('paquete', function ($q) use ($request) {
            $q->where('ciudad', 'like', '%' . $request->ciudadOrigen . '%');
        });
    }

    if ($request->filled('destino')) {
        $query->whereHas('paquete', function ($q) use ($request) {
            $q->where('pais', 'like', '%' . $request->destino . '%')
              ->orWhere('ciudad', 'like', '%' . $request->destino . '%');
        });
    }

    // 3. Cargar relación Paquete con datos necesarios
    $salidas = $query->with(['paquete' => function ($q) {
        $q->select('id', 'nombre', 'ciudad', 'pais'); // Columnas de Paquete
    }])->get();

    // 4. Formatear respuesta
    $resultado = $salidas->map(function ($salida) {
        return [
            'salida' => $salida->only(['id', 'fecha_desde', 'fecha_hasta', 'ciudad', 'pais']),
            'paquete' => $salida->paquete,
        ];
    });

    return $resultado->isEmpty()
        ? response()->json(['message' => 'No hay resultados'], 404)
        : response()->json($resultado);
}

public function buscarPaquetes(Request $request)
{
     // Obtener los parámetros de la solicitud
     $destino = $request->input('destino');
     $fechaDesde = $request->input('fecha_desde');
     $fechaHasta = $request->input('fecha_hasta');
     $cantidadPasajeros = $request->input('cantidad_pasajeros');
     return response()->json('hola');
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
