<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paquete;
use App\Models\PaqueteJulia;
use Carbon\Carbon;

class PaquetesController extends Controller
{
    public function index()
    {
        $paquetes = Paquete::paginate(50);
        $tarjetasJulia = [];
        return view('paquetes.index', compact('paquetes', 'tarjetasJulia'));
    }

    public function getPaquetes()
    {
        $paquetes = Paquete::with(['salidas' => function ($query) {
            $query->select(
                'id', 'paquete_id', 'fecha_desde', 'fecha_hasta',
                'single_precio', 'single_impuesto', 'single_otro', 'single_otro2',
                'doble_precio', 'doble_impuesto', 'doble_otro', 'doble_otro2',
                'triple_precio', 'triple_impuesto', 'triple_otro', 'triple_otro2',
                'cuadruple_precio', 'cuadruple_impuesto', 'cuadruple_otro', 'cuadruple_otro2'
            );
        }])->get();

        return response()->json($paquetes->toArray());
    }

    public function obtenerPaquetesPorDestino(Request $request)
    {
        $ciudadOrigen = $request->input('ciudadOrigen');
        $destino = $request->input('destino');
        $fechaSalida = $request->input('fechaSalida');
        $viajeros = $request->input('viajeros');

        $paquetes = Paquete::query();

        if ($destino) {
            $ciudadPrincipal = trim(explode(' - ', $destino)[0]);

            $paquetes->where(function ($query) use ($ciudadPrincipal) {
                $query->where('pais', 'like', "%{$ciudadPrincipal}%")
                    ->orWhere('ciudad', 'like', "%{$ciudadPrincipal}%")
                    ->orWhere('ciudad_iata', 'like', "%{$ciudadPrincipal}%");
            });
        }

        $paquetes->whereHas('salidas', function ($query) use ($ciudadOrigen, $fechaSalida, $viajeros) {
            if ($ciudadOrigen) {
                $query->where('ciudad', 'like', "%{$ciudadOrigen}%");
            }

            if ($fechaSalida) {
                $fecha = Carbon::parse($fechaSalida);
                $query->whereDate('fecha_viaje', '>=', $fecha->toDateString());
            }

            if ($viajeros) {
                switch ($viajeros) {
                    case 1: $query->where('single_precio', '>', 0); break;
                    case 2: $query->where('doble_precio', '>', 0); break;
                    case 3: $query->where('triple_precio', '>', 0); break;
                    case 4: $query->where('cuadruple_precio', '>', 0); break;
                }
            }
        });

        $paquetes->with(['salidas' => function ($query) {
            $query->select(
                'id', 'paquete_id', 'fecha_desde', 'fecha_hasta',
                'ciudad', 'pais',
                'single_precio', 'single_impuesto', 'single_otro', 'single_otro2',
                'doble_precio', 'doble_impuesto', 'doble_otro', 'doble_otro2',
                'triple_precio', 'triple_impuesto', 'triple_otro', 'triple_otro2',
                'cuadruple_precio', 'cuadruple_impuesto', 'cuadruple_otro', 'cuadruple_otro2',
                'fecha_viaje'
            );
        }]);

        $resultados = $paquetes->get();

        return $resultados->isEmpty()
            ? response()->json(['message' => 'No se encontraron paquetes.'], 404)
            : response()->json($resultados);
    }

    public function buscarPaquetes(Request $request)
    {
        $destino = $request->input('destino');
        $fechaDesde = $request->input('fecha_desde');
        $fechaHasta = $request->input('fecha_hasta');
        $cantidadPasajeros = $request->input('cantidad_pasajeros');

        return response()->json('hola');
    }
}
