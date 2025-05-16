@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Gestión de Pedidos</h1>

    @if($pedidos->isEmpty())
        <p>No hay pedidos registrados.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Actualizar Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->usuario->name }}</td>
                        <td>€{{ $pedido->total }}</td>
                        <td><strong>{{ ucfirst($pedido->estado) }}</strong></td>
                        <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.pedidos.actualizar', $pedido) }}">
                                @csrf
                                @method('PUT')
                                <select name="estado" class="form-select form-select-sm d-inline w-auto">
                                    <option value="pendiente" {{ $pedido->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="enviado" {{ $pedido->estado === 'enviado' ? 'selected' : '' }}>Enviado</option>
                                    <option value="entregado" {{ $pedido->estado === 'entregado' ? 'selected' : '' }}>Entregado</option>
                                </select>
                                <button class="btn btn-sm btn-success">Actualizar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
