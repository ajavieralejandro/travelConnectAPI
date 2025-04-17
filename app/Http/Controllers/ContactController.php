<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendSmtpEmail;

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
                'sender' => ['name' => 'Formulario de Contacto', 'email' => 'amorosijavier@gmail.com'],
                'to' => [['email' => 'amorosijavier@gmail.com', 'name' => 'Administrador del sitio']],
                'subject' => 'Nuevo mensaje desde el sitio',
                'htmlContent' => $contenido,
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Mensaje enviado correctamente.');
            } else {
                return back()->withErrors(['error' => 'Error al enviar el mensaje: ' . $response->body()]);
            }

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Excepción: ' . $e->getMessage()]);
        }
    }

}
