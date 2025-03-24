<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AgenciaController;
use App\Http\Controllers\SoapController;
use App\Http\Controllers\AllSeasonsController;
use App\Http\Controllers\JuliaController;
use App\Http\Controllers\PaquetesController;
use App\Http\Controllers\PaqueteAgenciaController;
use App\Http\Controllers\HotelTravelGate;


Route::get('/paquetes', [JuliaController::class, 'getPaquetes']);
Route::get('/get_paquetes2',[PaquetesController::class,'index']);
Route::get('/get_paquetes', [PaquetesController::class, 'getPaquetes'])->name('paquetes.get');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/paquetes/buscar', [PaquetesController::class, 'buscarPaquetes'])->name('paquetes.buscar');
Route::get('/buscar', function () {
    return view('buscar_paquetes');
})->name('paquetes.form');

use App\Http\Controllers\GeolocationController;

Route::get('/geolocation', [GeolocationController::class, 'getCoordinates']);
//Mover A Admin
Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/create_agencia',[AgenciaController::class,'createAgencia'])->name('agencias.create');
Route::get('/destinos',[HotelTravelGate::class,'getAllDestinations'])->name('hotel.destinations');

Route::post('/store_agencia',[AgenciaController::class,'store'])->name('agencias.store');
Route::get('/create_paquete',[PaqueteAgenciaController::class,'create'])->name('paquete.create');

Route::middleware('is_admin')->group(function () {
    Route::get('/register', [TenantController::class, 'showRegistrationForm'])->name('register');

    Route::post('/register', [TenantController::class, 'register']);    });


    Route::domain('{subdomain}.localhost')->group(function () {
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

Route::get('/search-hotels-2', [HotelTravelGate::class, 'searchHotelsGeo']);
Route::get('/tenants/{domain}', [TenantController::class, 'getTenant']);
Route::get('/agencia',[AgenciaController::class,'getAgencia'])->name('agencia.get');

Route::get('/seasons', [AllSeasonsController::class, 'getSeasons']);
Route::post('/paquetes/filtrar', [PaquetesController::class, 'obtenerPaquetesPorDestino'])->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
;
Route::post('/paquetes2/filtrar2', [PaquetesController::class, 'obtenerPaquetesPorDestino'])->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
;


Route::post('/hotels/search', [HotelTravelGate::class, 'searchHotels'])->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

// Luego, la ruta general
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
