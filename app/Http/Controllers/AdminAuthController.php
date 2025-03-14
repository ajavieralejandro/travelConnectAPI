<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agencia;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function dashboard(){
        $agencias = Agencia::paginate(10);
        return view('admin.dashboard',['agencias'=>$agencias]);
    }

    public function login(Request $request)
    {
        // Validar las credenciales
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }
}
