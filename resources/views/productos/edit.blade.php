@extends('layouts.app')

@section('title', 'Editar producto')

@section('content')
<h1 class="mb-3">Editar producto</h1>

<form action="{{ route('productos.update', $producto) }}" method="POST">
    @method('PUT')
    @include('productos.form')

    <div class="d-flex justify-content-end gap-2 mt-3">
        {{-- Cancelar --}}
        <a href="{{ route('productos.index') }}"
           class="btn btn-outline-secondary"
           title="Cancelar">
            <i class="bi bi-x-circle"></i>
        </a>

        {{-- Guardar --}}
        <button type="submit"
                class="btn btn-primary"
                title="Guardar cambios">
            <i class="bi bi-check2-circle"></i>
        </button>
    </div>
</form>
@endsection
