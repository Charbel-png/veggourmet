@extends('layouts.panel')

@section('title', 'Editar producto')

@section('content')
    <h1 class="h4 mb-3">Editar producto</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('productos.update', $producto) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('productos.form')

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary me-2">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
