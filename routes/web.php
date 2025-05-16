<?php

use Illuminate\Support\Facades\Route;
use App\Models\Producto;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PedidoAdminController;

// Ruta raíz redirige al catálogo
Route::get('/', function () {
    return redirect()->route('catalogo');
});

// Rutas públicas o sin middleware (si las hay) - aquí no hay

// Ruta catálogo visible a todos
Route::get('/catalogo', function () {
    $productos = Producto::with('categorias')->get();
    return view('catalogo', compact('productos'));
})->name('catalogo');

// Rutas carrito sin autenticación (opcional si quieres protegerlas)
Route::get('/carrito', [CarritoController::class, 'ver'])->name('carrito.ver');
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/finalizar', [CarritoController::class, 'finalizar'])->name('carrito.finalizar');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Historial de pedidos para usuario autenticado
    Route::get('/mis-pedidos', [PedidoController::class, 'misPedidos'])->name('mis-pedidos');

    // Rutas para usuarios con rol admin o editor
    Route::middleware(['rol:admin,editor'])->group(function () {
        Route::resource('productos', ProductoController::class)->except(['show']);
        Route::get('/productos/gestionar', function () {
            return view('productos.gestion');
        });
    });

    // Paneles específicos por rol
    Route::middleware(['rol:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        });

        // Panel de administración de pedidos
        Route::prefix('admin')->group(function () {
            Route::get('/pedidos', [PedidoAdminController::class, 'index'])->name('admin.pedidos');
            Route::put('/pedidos/{pedido}', [PedidoAdminController::class, 'actualizarEstado'])->name('admin.pedidos.actualizar');
        });
    });

    Route::middleware(['rol:editor'])->group(function () {
        Route::get('/editor/dashboard', function () {
            return view('editor.dashboard');
        });
    });

    Route::middleware(['rol:usuario'])->group(function () {
        Route::get('/compras', function () {
            return view('compras.index');
        });
    });

});
