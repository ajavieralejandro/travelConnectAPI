<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Agencia;
use App\Models\Tenant;
use App\Models\User;

class AgenciaController extends Controller
{
    public function index()
    {
        return response()->json(Agencia::all());
    }



public function store(Request $request)
{
    try {
        DB::beginTransaction(); // Inicia la transacción
        // Validar los datos de la solicitud
        $data = $request->validate([
            'subdomain' => 'required|string|unique:tenants,subdomain',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',

            'estado' => 'required|boolean',

            'color_principal' => 'required|string',
            'color_secundario' => 'required|string',
            'color_barra_superior' => 'required|string',
            'filtro_imagen_1' => 'required|boolean',
            'filtro_imagen_2' => 'required|boolean',
            'nombre_de_contacto' => 'required|string',
            'direccion' => 'required|string',
            'whatsapp' => 'required|string',
            'telefono' => 'required|string',

        ]);

        // Crear el tenant
        $tenant = Tenant::create([
            'subdomain' => $request->subdomain,
            'template' => 'default', // Puedes personalizar esto
        ]);

        // Crear el usuario asociado al tenant
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tenant_id' => $tenant->id,
        ]);

        // Asociar el tenant al request
        $data['tenant_id'] = $tenant->id;

       // Crear una subcarpeta con el nombre de la agencia si no existe
    $folderPath = 'agencias/' . $nombreAgencia;
    Storage::disk('public')->makeDirectory($folderPath);

    // Subir imágenes si existen
    if ($request->hasFile('favicon')) {
        // Guardar el archivo en la subcarpeta específica
        $data['favicon'] = $request->file('favicon')->store($folderPath, 'public');
    }

    if ($request->hasFile('logo')) {
        $data['logo'] = $request->file('logo')->store($folderPath, 'public');
    }

    if ($request->hasFile('fondo_1')) {
        $data['fondo_1'] = $request->file('fondo_1')->store($folderPath, 'public');
    }

    if ($request->hasFile('fondo_2')) {
        $data['fondo_2'] = $request->file('fondo_2')->store($folderPath, 'public');
    }
        $data['nombre']=$data['name'];
        $data['dominio']=$data['subdomain'];
        $data['mail']=$data['email'];
        // Crear la agencia con los datos procesados
        $agencia = Agencia::create($data);

        DB::commit(); // Confirma la transacción
        return redirect()->route('admin.dashboard')->with('success', 'Agencia y Tenant creados exitosamente.');

    } catch (\Exception $e) {
        DB::rollBack(); // Revierte la transacción en caso de error
        dd("Error al guardar la agencia y el tenant: " . $e->getMessage());
    }
}


    public function getAgencia(Request $request){
        $host = $request->getHost(); // Obtiene el host completo (subdominio.dominio.com)
        $subdominio = explode('.', $host)[0];
        $agencia = Agencia::where('dominio','=',$subdominio)->first();
        if(!$agencia){
            $agencia = Agencia::all()->first();
            return response()->json($agencia);
        }
        //if(isset($agencia['fondo_1']))
        //$agencia['fondo_1']= (request()->getSchemeAndHttpHost() . '/storage/' . ltrim($agencia->fondo_1, '/'));
        //if(isset($agencia['logo']))
        //$agencia['logo']= (request()->getSchemeAndHttpHost() . '/storage/' . ltrim($agencia->logo, '/'));
        return response()->json($agencia);
    }


    public function show(Agencia $agencia)
    {
        return response()->json($agencia);
    }

    public function update(Request $request, Agencia $agencia)
    {
        $agencia->update($request->all());
        return response()->json($agencia);
    }

    public function createAgencia(){
        return view('admin.create_agencia');
    }

    public function destroy(Agencia $agencia)
    {
        $agencia->delete();
        return response()->json(['message' => 'Agencia eliminada']);
    }
}
