@extends('layouts.app')

@section('title', 'Editar ingrediente')

@section('content')
    <h1>Editar ingrediente</h1>

    <form action="{{ route('ingredientes.update', $ingrediente) }}" method="POST">
        @method('PUT')
        @include('ingredientes._form')

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('ingredientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
