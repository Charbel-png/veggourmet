@extends('layouts.app')

@section('title', 'Editar cliente')

@section('content')
    <h1>Editar cliente</h1>

    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
        @method('PUT')
        @include('clientes._form')

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
