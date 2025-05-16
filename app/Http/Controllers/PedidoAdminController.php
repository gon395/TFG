<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\User;


class PedidoAdminController extends Controller
{
public function usuario()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function index()
{
    $pedidos = Pedido::with('usuario')->orderBy('created_at', 'desc')->get();
    return view('admin.pedidos', compact('pedidos'));
}

public function actualizarEstado(Request $request, Pedido $pedido)
{
    $request->validate(['estado' => 'required|in:pendiente,enviado,entregado']);
    $pedido->estado = $request->estado;
    $pedido->save();
    return redirect()->route('admin.pedidos')->with('success', 'Estado actualizado');
}


}
