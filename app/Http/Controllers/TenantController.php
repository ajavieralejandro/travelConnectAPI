<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class TenantController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Asegúrate de que esta vista exista
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'subdomain' => 'required|string|unique:tenants,subdomain',
        ]);

        // Crear el tenant
        $tenant = Tenant::create([
            'subdomain' => $request->subdomain,
            'template' => 'default', // Puedes personalizar esto
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tenant_id' => $tenant->id,
        ]);

        return redirect()->route('welcome')->with('success', 'Usuario registrado con éxito');
    }

    public function show(Request $request)
{
    // Obtener el subdominio de la solicitud
    $subdomain = explode('.', $request->getHost())[0];

    // Verificar si el subdominio está registrado en la base de datos
    $tenant = Tenant::where('subdomain', $subdomain)->first();

    if (!$tenant) {
        abort(404, 'Subdominio no encontrado');
    }

    if($tenant->default){
        // Pasar los datos a la vista de React
    return view('tenant', [
        'tenantData' => $tenant,
        'subdomain' => $subdomain,
    ]);
    }

    else
    {
        return view('tenant2', [
            'tenantData' => $tenant,
            'subdomain' => $subdomain,
        ]);
    }


}


public function getTenant($domain)
{
    // Validar que el dominio no esté vacío
    if (empty($domain)) {
        return response()->json(['message' => 'El dominio es requerido'], 400);
    }

    // Cachear la respuesta por 60 minutos
    $tenant = Cache::remember("tenant_{$domain}", 60, function () use ($domain) {
        return Tenant::where('subdomain', $domain)->first();
    });

    // Si no se encuentra el tenant, devolver un error 404
    if (!$tenant) {
        return response()->json(['message' => 'Tenant no encontrado'], 404);
    }

    // Devolver los datos del tenant en formato JSON
    return response()->json($tenant);
}
}
