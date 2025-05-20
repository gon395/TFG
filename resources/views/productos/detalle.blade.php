@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            @if($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-fluid" alt="{{ $producto->nombre }}">
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $producto->nombre }}</h1>
            <p class="text-muted">Precio: <strong>€{{ $producto->precio }}</strong></p>
            <p>{{ $producto->descripcion }}</p>

            <p>
                Categorías:
                @foreach($producto->categorias as $cat)
                    <span class="badge bg-secondary">{{ $cat->nombre }}</span>
                @endforeach
            </p>

            <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}">
                @csrf
                <button type="submit" class="btn btn-success">Añadir al carrito</button>
            </form>
        </div>
    </div>
</div>
@endsection
