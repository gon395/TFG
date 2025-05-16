@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Mis Pedidos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($pedidos->isEmpty())
        <p class="text-muted">No has realizado ningún pedido aún.</p>
    @else
        <table class="table table-hover mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>€{{ $pedido->total }}</td>
                        <td>
                            <span class="badge 
                                @if($pedido->estado === 'pendiente') bg-warning
                                @elseif($pedido->estado === 'enviado') bg-primary
                                @elseif($pedido->estado === 'entregado') bg-success
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($pedido->estado) }}
                            </span>
                        </td>
                        <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <button class="btn btn-outline-info btn-sm" onclick="toggleDetalles({{ $pedido->id }})">
                                Ver detalles
                            </button>
                        </td>
                    </tr>
                    <tr id="detalles-{{ $pedido->id }}" style="display: none;">
                        <td colspan="5">
                            <ul class="list-group list-group-flush">
                                @foreach($pedido->detalles as $detalle)
                                    <li class="list-group-item">
                                        <strong>{{ $detalle->producto->nombre }}</strong> -
                                        Cantidad: {{ $detalle->cantidad }} -
                                        Precio: €{{ $detalle->precio_unitario }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
function toggleDetalles(id) {
    const fila = document.getElementById('detalles-' + id);
    fila.style.display = fila.style.display === 'none' ? '' : 'none';
}
</script>
@endsection
