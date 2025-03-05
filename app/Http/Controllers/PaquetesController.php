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
        $tarjetasJulia = PaqueteJulia::all();
        return view('paquetes.index', compact('paquetes','tarjetasJulia'));
    }

    public function getPaquetes(){
        $paquetes = Paquete::all();
        return response()->json($paquetes);

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
