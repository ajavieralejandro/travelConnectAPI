<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\AdminAuthController;


Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::middleware('is_admin')->group(function () {
    Route::get('/register', [TenantController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [TenantController::class, 'register']);    });


Route::domain('{subdomain}.localhost')->group(function () {
    Route::get('/', [TenantController::class, 'show']);
});

// Luego, la ruta general
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
