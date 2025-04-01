<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Providers\JuliaServiceProvider;

class JuliaController extends Controller
{
    protected $juliaService;

    public function __construct(JuliaServiceProvider $juliaService)
    {
        $this->juliaService = $juliaService;
    }

    public function getPaquetes(Request $request)
    {
        try {
            $response = $this->juliaService->obtenerPaquetes($request);
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error en getPaquetes:', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Error al obtener paquetes',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function enviarPaquetes(Request $request)
    {
        try {
            $response = $this->juliaService->enviarPaquetes($request);
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error en enviarPaquetes:', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Error al enviar paquetes',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
