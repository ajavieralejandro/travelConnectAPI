<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\SoapController;
use App\Http\Controllers\AllSeasonsController;
use App\Http\Controllers\JuliaController;
use App\Http\Controllers\PaquetesController;


Route::get('/paquetes', [JuliaController::class, 'getPaquetes']);
Route::get('/ver_paquetes', [PaquetesController::class, 'index'])->name('paquetes.index');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/paquetes/buscar', [PaquetesController::class, 'buscarPaquetes'])->name('paquetes.buscar');
Route::get('/buscar', function () {
    return view('buscar_paquetes');
})->name('paquetes.form');


Route::middleware('is_admin')->group(function () {
    Route::get('/register', [TenantController::class, 'showRegistrationForm'])->name('register');

    Route::post('/register', [TenantController::class, 'register']);    });


    Route::domain('{subdomain}.triptest.com.ar')->group(function () {
        Route::get('/', [TenantController::class, 'show']);
    });
Route::get('/send-soap-request', [SoapController::class, 'sendSoapRequest']);
Route::get('/tenant-check', function () {
    dd([
        'tenant' => tenant(), // Should return "javier" tenant
        'host' => request()->getHost(), // Should be "javier.triptest.com.ar"
        'config' => config('tenancy.central_domains') // Should include "triptest.com.ar"
    ]);
});

Route::get('/tenants/{domain}', [TenantController::class, 'getTenant']);


Route::get('/seasons', [AllSeasonsController::class, 'getSeasons']);
Route::get('/paquetes/filtrar', [PaquetesController::class, 'obtenerPaquetesPorDestino']);

// Luego, la ruta general
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
