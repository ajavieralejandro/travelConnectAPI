<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'email' => 'required|email',
            'agencia' => 'required',
            'pais' => 'required',
            'mensaje' => 'required',
        ]);

        $contenido = <<<EOT
<p><strong>Nuevo mensaje desde el formulario de contacto:</strong></p>
<p><strong>Nombre:</strong> {$validated['nombre']}</p>
<p><strong>Apellido:</strong> {$validated['apellido']}</p>
<p><strong>Teléfono:</strong> {$validated['telefono']}</p>
<p><strong>Email:</strong> {$validated['email']}</p>
<p><strong>Agencia:</strong> {$validated['agencia']}</p>
<p><strong>País:</strong> {$validated['pais']}</p>
<p><strong>Mensaje:</strong><br>{$validated['mensaje']}</p>
EOT;

        try {
            $response = Http::withHeaders([
                'api-key' => config('services.brevo.key'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'name' => 'formulario de contacto',
                    'email' => 'amorosijavier@gmail.com', // este mail debe estar validado en brevo
                ],
                'to' => [
                    ['email' => 'amorosijavier@gmail.com', 'name' => 'administrador'],
                    ['email' => 'paonovick@hotmail.com', 'name' => 'paonovick'],
                    ['email' => 'tomas@travelconnect.com.ar', 'name' => 'tomas'],
                ],
                'subject' => 'nuevo mensaje desde el sitio',
                'htmlContent' => $contenido,
            ]);

            if ($response->successful()) {
                return back()->with('success', 'mensaje enviado correctamente.');
            } else {
                return back()->withErrors(['error' => 'error al enviar el mensaje: ' . $response->body()]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'excepción al enviar: ' . $e->getMessage()]);
        }
    }
}
