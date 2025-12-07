@extends('layouts.app')

@section('title', 'Nuevo producto')

@section('content')
<h1 class="mb-3">Nuevo producto</h1>

<form action="{{ route('productos.store') }}" method="POST">
    @include('productos.form')
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endsection
