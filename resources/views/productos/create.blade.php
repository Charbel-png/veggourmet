@extends('layouts.panel')

@section('title', 'Nuevo producto')

@section('content')
<h1 class="mb-3">Nuevo producto</h1>

<form action="{{ route('productos.store') }}" method="POST">
    @include('productos.form')

    <div class="d-flex justify-content-end gap-2 mt-3">
        <a href="{{ route('productos.index') }}"
           class="btn btn-outline-secondary"
           title="Cancelar">
            <i class="bi bi-x-circle"></i>
        </a>

        <button type="submit"
                class="btn btn-success"
                title="Guardar producto">
            <i class="bi bi-check2-circle"></i>
        </button>
    </div>
</form>

@endsection
