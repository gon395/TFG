<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/producto/{id}', [ProductoController::class, 'mostrar'])->name('producto.mostrar');

Route::get('/catalogo', function () {
    $productos = Producto::with('categorias')->paginate(6); // 6 productos por página
    return view('catalogo', compact('productos'));
})->name('catalogo');



require __DIR__.'/auth.php';
