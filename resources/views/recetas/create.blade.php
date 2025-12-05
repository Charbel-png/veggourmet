@extends('layouts.app')

@section('title', 'Agregar ingrediente a ' . $producto->nombre)

@section('content')
    <h1>Agregar ingrediente a: {{ $producto->nombre }}</h1>

    <form action="{{ route('recetas.store', $producto) }}" method="POST">
        @include('recetas._form')

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('recetas.index', $producto) }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
