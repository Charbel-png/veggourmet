@extends('layouts.app')

@section('title', 'Nuevo ingrediente')

@section('content')
    <h1>Nuevo ingrediente</h1>

    <form action="{{ route('ingredientes.store') }}" method="POST">
        @include('ingredientes._form')

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('ingredientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
