@extends('layouts.app')

@section('content')
<h1>Editar producto</h1>

<form method="POST" action="{{ route('productos.update', $producto) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Nombre:</label>
    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}"><br>

    <label>Descripción:</label>
    <textarea name="descripcion">{{ old('descripcion', $producto->descripcion) }}</textarea><br>

    <label>Precio:</label>
    <input type="number" name="precio" step="0.01" value="{{ old('precio', $producto->precio) }}"><br>

    <label>Imagen:</label>
    <input type="file" name="imagen"><br>
    @if($producto->imagen)
        <img src="{{ asset('storage/' . $producto->imagen) }}" width="100"><br>
    @endif

    <label>Categorías:</label><br>
    @foreach($categorias as $categoria)
        <label>
            <input type="checkbox" name="categorias[]" value="{{ $categoria->id }}"
                {{ $producto->categorias->contains($categoria->id) ? 'checked' : '' }}>
            {{ $categoria->nombre }}
        </label><br>
    @endforeach

    <button type="submit">Actualizar</button>
</form>
@endsection
