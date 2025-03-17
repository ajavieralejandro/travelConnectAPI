<?php

namespace App\Http\Controllers;

use App\Models\PaqueteAgencia;
use App\Models\Agencia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class PaqueteAgenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $agencias = Agencia::all();
        return view('admin.paquetes.create_paquete',['agencias'=>$agencias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PaqueteAgencia $paqueteAgencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaqueteAgencia $paqueteAgencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaqueteAgencia $paqueteAgencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaqueteAgencia $paqueteAgencia)
    {
        //
    }
}
