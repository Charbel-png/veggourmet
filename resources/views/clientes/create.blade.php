@extends('layouts.app')

@section('title', 'Nuevo cliente')

@section('content')
    <h1>Nuevo cliente</h1>

    <form action="{{ route('clientes.store') }}" method="POST">
        @include('clientes._form')

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
