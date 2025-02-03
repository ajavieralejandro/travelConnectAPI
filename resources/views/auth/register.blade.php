@extends('layout.app') <!-- Extiende tu layout principal -->

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h1 class="mb-6 text-2xl font-bold text-center">Registro de Usuario</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Campo Nombre -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre:</label>
                <input id="name" type="text" name="name" required autofocus
                       class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Campo Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input id="email" type="email" name="email" required
                       class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Campo Contraseña -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
                <input id="password" type="password" name="password" required
                       class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Campo Confirmar Contraseña -->
            <div class="mb-6">
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirmar Contraseña:</label>
                <input id="password-confirm" type="password" name="password_confirmation" required
                       class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Campo Subdominio -->
            <div class="mb-6">
                <label for="subdomain" class="block text-sm font-medium text-gray-700">Subdominio:</label>
                <input id="subdomain" type="text" name="subdomain" required
                       class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Botón de Registro -->
            <div>
                <button type="submit" class="w-full px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Registrar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
