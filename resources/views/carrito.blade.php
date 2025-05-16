@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Carrito de Compras</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('carrito') && count(session('carrito')) > 0)
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach(session('carrito') as $item)
                    @php $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item['nombre'] }}</td>
                        <td>€{{ $item['precio'] }}</td>
                        <td>{{ $item['cantidad'] }}</td>
                        <td>€{{ $subtotal }}</td>
                        <td>
                            <form method="POST" action="{{ route('carrito.eliminar', $item['id']) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="mt-4">Total: €{{ $total }}</h4>

        <form method="POST" action="{{ route('carrito.finalizar') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-success">Finalizar compra</button>
        </form>
    @else
        <p class="mt-3">No hay productos en el carrito.</p>
    @endif
</div>
@endsection
