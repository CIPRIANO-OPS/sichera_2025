<?php

use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EjemploController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('ejemplo');
});

// Authentication routes (provided by Breeze)
require __DIR__ . '/auth.php';

// Protected routes (require authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Example route
    Route::get('/ejemplo', [EjemploController::class, 'index'])->name('ejemplo');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource routes
    Route::resource('clientes', ClienteController::class);
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('ventas', VentaController::class);
    Route::resource('mesas', MesaController::class);

    // Rutas especiales para mesas
    Route::get('/restaurant', [MesaController::class, 'restaurant'])->name('mesas.restaurant');
    Route::post('/mesas/{mesa}/separar', [MesaController::class, 'separar'])->name('mesas.separar');
    Route::post('/mesas/{mesa}/crear-comanda', [MesaController::class, 'crearComanda'])->name('mesas.crear-comanda');
});
