<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendSmtpEmail;

class ContactController extends Controller
{
    public function send(Request $request, TransactionalEmailsApi $brevo)
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
            $email = new SendSmtpEmail([
                'subject' => 'Nuevo mensaje desde el sitio',
                'sender' => [
                    'name' => 'Formulario de Contacto',
                    'email' => 'amorosijavier@gmail.com', // Este mail debe estar validado en Brevo
                ],
                'to' => [
                    ['email' => 'amorosijavier@gmail.com', 'name' => 'Administrador del sitio'],
                ],
                'htmlContent' => $contenido,
            ]);

            $brevo->sendTransacEmail($email);

            return back()->with('success', 'Mensaje enviado correctamente.');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
            return back()->withErrors(['error' => 'Error al enviar el mensaje: ' . $e->getMessage()]);
        }
    }
}
