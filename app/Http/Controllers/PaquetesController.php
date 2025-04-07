<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paquete;
use App\Models\Salida;
use App\Models\PaqueteJulia;
use Carbon\Carbon;
use App\Http\Providers\JuliaServiceProvider;

class PaquetesController extends Controller
{
    public function index()
    {
        $paquetes = Paquete::with('salidas')->paginate;
        $tarjetasJulia = [];
        return view('paquetes.index', compact('paquetes', 'tarjetasJulia'));
    }

    public function importar(Request $request)
    {
        $agencia = $request->agencia; // La agencia viene del middleware

        // APIs habilitadas de la agencia (ejemplo: ['julia', 'otra_api'])
        $apisHabilitadas = $agencia->apis_habilitadas ?? [];

        $resultados = [];

        if (in_array('julia', $apisHabilitadas)) {
            $resultados['julia'] = $this->importarDesdeJulia();
        }

        if (in_array('otra_api', $apisHabilitadas)) {
            $resultados['otra_api'] = $this->importarDesdeOtraAPI();
        }

        return response()->json([
            'message' => 'Importación completada',
            'detalles' => $resultados
        ]);
    }

    private function importarDesdeJulia(Request $request)
    {
        try {
            $response = $this->juliaService->enviarPaquetes($request);
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error en enviarPaquetes:', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Error al enviar paquetes',
                'message' => $e->getMessage()
            ], 500);}
    }

    private function importarDesdeOtraAPI()
    {
        // Lógica específica para otra API

        return 'Importación desde otra API ejecutada';
    }



    public function getPaquetes()
    {
        $paquetes = Paquete::with('salidas')->get();

    $paquetes->transform(function ($paquete) {
        // Verificamos si tiene salidas
        if ($paquete->salidas->isNotEmpty()) {
            // Tomamos el doble_precio de la primera salida (podés cambiar a la que necesites)
            $paquete->precio = $paquete->salidas->first()->doble_precio;
        } else {
            $paquete->precio = null;
        }

        return $paquete;
    });

    return response()->json($paquetes);
    }

    public function obtenerPaquetesPorDestino(Request $request)
    {
        $ciudadOrigen = $request->input('ciudadOrigen');
        $destino = $request->input('destino');
        $fechaSalida = $request->input('fechaSalida');
        $viajeros = $request->input('viajeros');
        $id = $request->input('id');
        if($id)
            return response()->json(Paquete::find($id));
        // Empezamos la consulta de Paquetes
        $paquetes = Paquete::query();

        // Filtro por destino
        if ($destino) {
            $ciudadPrincipal = trim(explode(' - ', $destino)[0]);

            $paquetes->where(function ($query) use ($ciudadPrincipal) {
                $query->where('pais', 'like', "%{$ciudadPrincipal}%")
                    ->orWhere('ciudad', 'like', "%{$ciudadPrincipal}%")
                    ->orWhere('ciudad_iata', 'like', "%{$ciudadPrincipal}%");
            });
        }

        // Filtro de salidas y condiciones
        $paquetes->whereHas('salidas', function ($query) use ($ciudadOrigen, $fechaSalida, $viajeros) {
            // Filtrar por ciudad de origen
            if ($ciudadOrigen) {
                $query->where('ciudad', 'like', "%{$ciudadOrigen}%");
            }

            // Filtrar por fecha de salida
            if ($fechaSalida) {
                $fecha = Carbon::parse($fechaSalida)->startOfDay();

                $query->where(function($subQuery) use ($fecha) {
                    $subQuery->where(function($q) use ($fecha) {
                        $q->whereNotNull('fecha_viaje')
                          ->whereDate('fecha_viaje', '>=', $fecha->toDateString());
                    })
                    ->orWhere(function($q) use ($fecha) {
                        $q->whereNull('fecha_viaje')
                          ->whereDate('fecha_desde', '<=', $fecha->toDateString())
                          ->whereDate('fecha_hasta', '>=', $fecha->toDateString());
                    });
                });
            }



            // Filtro por viajeros y precios correspondientes
            if ($viajeros) {
                $query->where(function ($q) use ($viajeros) {
                    switch ($viajeros) {
                        case 1:
                            $q->where('single_precio', '>', 0);
                            break;
                        case 2:
                            $q->where('doble_precio', '>', 0);
                            break;
                        case 3:
                            $q->where('triple_precio', '>', 0);
                            break;
                        case 4:
                            $q->where('cuadruple_precio', '>', 0);
                            break;
                    }
                });
            }
        });

        // Cargar las salidas filtradas
        $paquetes->with(['salidas' => function ($query) use ($ciudadOrigen, $fechaSalida, $viajeros) {
            // Reaplicar los filtros dentro de `with` para las salidas
            if ($ciudadOrigen) {
                $query->where('ciudad', 'like', "%{$ciudadOrigen}%");
            }

            if ($fechaSalida) {
                $fecha = Carbon::parse($fechaSalida)->startOfDay();

                $query->where(function($subQuery) use ($fecha) {
                    $subQuery->where(function($q) use ($fecha) {
                        $q->whereNotNull('fecha_viaje')
                          ->whereDate('fecha_viaje', '>=', $fecha->toDateString());
                    })
                    ->orWhere(function($q) use ($fecha) {
                        $q->whereNull('fecha_viaje')
                          ->whereDate('fecha_desde', '<=', $fecha->toDateString())
                          ->whereDate('fecha_hasta', '>=', $fecha->toDateString());
                    });
                });
            }


            if ($viajeros) {
                $query->where(function ($q) use ($viajeros) {
                    switch ($viajeros) {
                        case 1:
                            $q->where('single_precio', '>', 0);
                            break;
                        case 2:
                            $q->where('doble_precio', '>', 0);
                            break;
                        case 3:
                            $q->where('triple_precio', '>', 0);
                            break;
                        case 4:
                            $q->where('cuadruple_precio', '>', 0);
                            break;
                    }
                });
            }
        }]);

        // Ejecutar la consulta
        $resultados = $paquetes->get();

        // Verificar si hay resultados
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
