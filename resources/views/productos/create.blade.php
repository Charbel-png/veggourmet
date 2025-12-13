{{-- resources/views/productos/create.blade.php --}}

@extends('admin.admin') {{-- o lo que use tu otra vista, por ejemplo 'layouts.app' --}}

@section('title', 'Nuevo producto')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-4">Nuevo producto</h1>

    {{-- Errores generales --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups...</strong> Hay errores en el formulario.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('productos.store') }}"
          enctype="multipart/form-data">
        @csrf

        {{-- Campos del formulario --}}
        @include('productos.form')

        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                Guardar producto
            </button>
        </div>
    </form>
</div>
@endsection
