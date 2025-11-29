@extends('layouts.app')

@section('title', 'Nuevo producto')

@section('content')
    <h1>Nuevo producto</h1>

    <form action="{{ route('productos.store') }}" method="POST">
        @include('productos._form')

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
