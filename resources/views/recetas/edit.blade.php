@extends('layouts.app')

@section('title', 'Editar ingrediente de ' . $producto->nombre)

@section('content')
    <h1>Editar cantidad de ingrediente</h1>

    <p><strong>Producto:</strong> {{ $producto->nombre }}</p>
    <p><strong>Ingrediente:</strong> {{ $ingrediente->nombre }}</p>

    <form action="{{ route('recetas.update', [$producto, $ingrediente->id_ingrediente]) }}" method="POST">
        @method('PUT')

        @csrf
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number"
                   step="0.001"
                   min="0"
                   name="cantidad"
                   id="cantidad"
                   class="form-control"
                   value="{{ old('cantidad', $receta->cantidad) }}"
                   required>
            @error('cantidad')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('recetas.index', $producto) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
