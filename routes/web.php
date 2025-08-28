<?php

use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\PlatoCategoriaController;
use App\Http\Controllers\PlatoController;
use App\Http\Controllers\ComandaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EjemploController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
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
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('ventas', VentaController::class);
    Route::resource('mesas', MesaController::class);
    Route::resource('plato-categorias', PlatoCategoriaController::class);
    Route::resource('platos', PlatoController::class);
    Route::resource('comandas', ComandaController::class);
    Route::resource('pedidos', PedidoController::class);

    // Rutas especiales para mesas
    Route::get('/restaurant', [MesaController::class, 'restaurant'])->name('mesas.restaurant');
    Route::get('/api/mesas', [MesaController::class, 'getMesasJson'])->name('mesas.json');
    Route::post('/mesas/{mesa}/separar', [MesaController::class, 'separar'])->name('mesas.separar');
    Route::post('/mesas/{mesa}/crear-comanda', [MesaController::class, 'crearComanda'])->name('mesas.crear-comanda');

    // Rutas especiales para plato-categorias
    Route::get('/api/plato-categorias/select', [PlatoCategoriaController::class, 'getForSelect'])->name('plato-categorias.select');

    // Rutas especiales para platos
    Route::get('/api/platos/categoria', [PlatoController::class, 'getPorCategoria'])->name('platos.por-categoria');
    Route::get('/api/platos/tipos', [PlatoController::class, 'getTipos'])->name('platos.tipos');
    
    // Rutas especiales para comandas
    Route::get('/api/comandas/categorias', [ComandaController::class, 'getCategorias'])->name('comandas.categorias');
    Route::get('/api/comandas/platos-categoria', [ComandaController::class, 'getPlatosPorCategoria'])->name('comandas.platos-categoria');
    Route::post('/comandas/{comanda}/cerrar', [ComandaController::class, 'cerrar'])->name('comandas.cerrar');
    Route::post('/comandas/{comanda}/cancelar', [ComandaController::class, 'cancelar'])->name('comandas.cancelar');
    
    // Rutas especiales para pedidos
    Route::post('/pedidos/{pedido}/cambiar-estado', [PedidoController::class, 'cambiarEstado'])->name('pedidos.cambiar-estado');
    
    // Rutas especiales para usuarios
    Route::get('/api/usuarios/data', [UsuarioController::class, 'getData'])->name('usuarios.data');
});
