<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeolocationController extends Controller
{
    public function getCoordinates(Request $request)
    {
        $destination = $request->input('destination'); // Obtener el destino desde el request

        if (!$destination) {
            return response()->json(['error' => 'El destino es requerido'], 400);
        }

        // API Key de OpenCage (sustituir con tu clave)
        $apiKey = env('OPENCAGE_API_KEY');
        $url = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode($destination) . "&key=" . $apiKey;

        // Hacer la petición a la API
        $response = Http::get($url);
        $data = $response->json();

        if ($response->failed() || empty($data['results'])) {
            return response()->json(['error' => 'No se encontraron coordenadas para el destino'], 404);
        }

        // Extraer latitud y longitud
        $location = $data['results'][0]['geometry'];

        return response()->json([
            'destination' => $destination,
            'latitude' => $location['lat'],
            'longitude' => $location['lng']
        ]);
    }
}
