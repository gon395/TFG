<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    public function misPedidos()
    {
        $pedidos = Pedido::with('detalles.producto')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mis-pedidos', compact('pedidos'));
    }
}
