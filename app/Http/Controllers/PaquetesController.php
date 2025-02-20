<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paquete;
use App\Models\PaqueteJulia;

class PaquetesController extends Controller
{
    //
    public function index()
    {
        $paquetes = Paquete::paginate(50);
        $tarjetasJulia = PaqueteJulia::all();
        return view('paquetes.index', compact('paquetes','tarjetasJulia'));
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

}
