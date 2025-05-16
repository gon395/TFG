@extends('layouts.app')

@section('content')
<h1>Crear nuevo producto</h1>

<form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
    @csrf

    <label>Nombre:</label>
    <input type="text" name="nombre" value="{{ old('nombre') }}"><br>

    <label>Descripción:</label>
    <textarea name="descripcion">{{ old('descripcion') }}</textarea><br>

    <label>Precio:</label>
    <input type="number" name="precio" step="0.01" value="{{ old('precio') }}"><br>

    <label>Imagen:</label>
    <input type="file" name="imagen"><br>

    <label>Categorías:</label><br>
    @foreach($categorias as $categoria)
        <label>
            <input type="checkbox" name="categorias[]" value="{{ $categoria->id }}">
            {{ $categoria->nombre }}
        </label><br>
    @endforeach

    <button type="submit">Guardar</button>
</form>
@endsection
