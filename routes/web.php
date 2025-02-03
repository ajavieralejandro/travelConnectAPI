<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
Route::middleware('is_admin')->group(function () {
    Route::get('/register', [TenantController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [TenantController::class, 'register']);});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
