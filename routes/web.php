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

Route::middleware('is_admin')->group(function () {
    Route::get('/register', [TenantController::class, 'showRegistrationForm'])->name('register');

    Route::post('/register', [TenantController::class, 'register']);    });


Route::domain('{subdomain}.localhost')->group(function () {
    Route::get('/', [TenantController::class, 'show']);
});

Route::get('/send-soap-request', [SoapController::class, 'sendSoapRequest']);


Route::get('/tenants/{domain}', [TenantController::class, 'getTenant']);


Route::get('/seasons', [AllSeasonsController::class, 'getSeasons']);
Route::get('/paquetes/filtrar', [PaquetesController::class, 'obtenerPaquetesPorDestino']);

// Luego, la ruta general
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
