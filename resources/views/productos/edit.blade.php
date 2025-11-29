@extends('layouts.app')

@section('title', 'Editar producto')

@section('content')
    <h1>Editar producto</h1>

    <form action="{{ route('productos.update', $producto) }}" method="POST">
        @method('PUT')
        @include('productos._form')

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
