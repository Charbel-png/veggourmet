@extends('layouts.app')

@section('title', 'Editar categoría')

@section('content')
<h1 class="mb-3">Editar categoría</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('categorias.update', $categoria) }}" method="POST">
    @method('PUT')
    @include('categorias.form')

    <div class="d-flex justify-content-end gap-2 mt-3">
        <a href="{{ route('categorias.index') }}"
           class="btn btn-outline-secondary"
           title="Cancelar">
            <i class="bi bi-x-circle"></i>
        </a>

        <button type="submit"
                class="btn btn-primary"
                title="Actualizar categoría">
            <i class="bi bi-check2-circle"></i>
        </button>
    </div>
</form>
@endsection
