<?php

namespace App\Http\Controllers;

use App\Models\Agencia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgenciaController extends Controller
{
    public function index()
    {
        return response()->json(Agencia::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'estado' => 'required|boolean',
            'nombre' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'dominio' => 'required|string|unique:agencias',
            'quienes_somos_es' => 'required|string',
            'quienes_somos_en' => 'required|string',
            'quienes_somos_pt' => 'required|string',
            'color_principal' => 'required|string',
            'color_secundario' => 'required|string',
            'color_barra_superior' => 'required|string',
            'filtro_imagen_1' => 'required|boolean',
            'filtro_imagen_2' => 'required|boolean',
            'nombre_de_contacto' => 'required|string',
            'direccion' => 'required|string',
            'whatsapp' => 'required|string',
            'mail' => 'required|string|email',
            'telefono' => 'required|string',
            'info_contacto_es' => 'required|string',
            'info_contacto_en' => 'required|string',
            'info_contacto_pt' => 'required|string',
        ]);

        $data['password'] = Hash::make($data['password']);
        $agencia = Agencia::create($data);
        return response()->json($agencia, 201);
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

    public function destroy(Agencia $agencia)
    {
        $agencia->delete();
        return response()->json(['message' => 'Agencia eliminada']);
    }
}
