@extends('layouts.app')

@section('title', 'Editar producto')

@section('content')
<h1 class="mb-3">Editar producto</h1>

<form action="{{ route('productos.update', $producto) }}" method="POST">
    @method('PUT')
    @include('productos.form')
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
@endsection
