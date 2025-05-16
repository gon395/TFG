<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;


class CarritoController extends Controller
{
    
public function ver()
{
    return view('carrito');
}

public function agregar(Request $request, $id)
{
    $producto = Producto::findOrFail($id);
    $carrito = session()->get('carrito', []);
    if (isset($carrito[$id])) {
        $carrito[$id]['cantidad']++;
    } else {
        $carrito[$id] = [
            "id" => $producto->id,
            "nombre" => $producto->nombre,
            "precio" => $producto->precio,
            "cantidad" => 1
        ];
    }
    session()->put('carrito', $carrito);
    return redirect()->back()->with('success', 'Producto añadido al carrito');
}

public function eliminar($id)
{
    $carrito = session()->get('carrito', []);
    if (isset($carrito[$id])) {
        unset($carrito[$id]);
        session()->put('carrito', $carrito);
    }
    return redirect()->route('carrito.ver');
}

public function finalizar()
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para finalizar la compra');
    }

    $carrito = session('carrito', []);
    if (empty($carrito)) {
        return redirect()->route('carrito.ver')->with('error', 'Tu carrito está vacío');
    }

    $total = array_reduce($carrito, function ($carry, $item) {
        return $carry + ($item['precio'] * $item['cantidad']);
    }, 0);

    $pedido = \App\Models\Pedido::create([
        'user_id' => auth()->id(),
        'total' => $total,
        'estado' => 'pendiente'
    ]);

    foreach ($carrito as $item) {
        \App\Models\DetallePedido::create([
            'pedido_id' => $pedido->id,
            'producto_id' => $item['id'],
            'cantidad' => $item['cantidad'],
            'precio_unitario' => $item['precio']
        ]);
    }

    session()->forget('carrito');

    return redirect()->route('catalogo')->with('success', 'Compra registrada correctamente');
}


}