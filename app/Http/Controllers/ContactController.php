<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            'provincia' => 'required',
            'mensaje' => 'required',
        ]);

        $contenido = <<<EOT
Nuevo mensaje desde el formulario de contacto:

Nombre: {$validated['nombre']}
Apellido: {$validated['apellido']}
Teléfono: {$validated['telefono']}
Email: {$validated['email']}
Agencia: {$validated['agencia']}
País: {$validated['pais']}
Provincia: {$validated['provincia']}

Mensaje:
{$validated['mensaje']}
EOT;

        Mail::raw($contenido, function ($message) {
            $message->to('amorosijavier@gmail.com')
                    ->subject('Nuevo mensaje desde el sitio');
        });

        return back()->with('success', 'Mensaje enviado correctamente.');
    }
}
