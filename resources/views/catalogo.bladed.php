@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Catálogo de Productos</h1>

    <div class="mb-4">
        <input type="text" id="busqueda" class="form-control" placeholder="Buscar productos...">
    </div>

    <div class="row">
        @foreach($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('producto.mostrar', $producto->id) }}">{{ $producto->nombre }}</a>
                        </h5>

                        <p class="card-text">€{{ $producto->precio }}</p>
                        <p>
                            @foreach($producto->categorias as $cat)
                                <span class="badge bg-secondary">{{ $cat->nombre }}</span>
                            @endforeach
                        </p>
                        <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

</div> {{-- fin del .row --}}

<div class="d-flex justify-content-center">
    {{ $productos->links() }}
</div>

