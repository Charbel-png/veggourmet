@extends('layouts.panel')

@section('title', 'Nuevo producto')

@section('content')
    <h1 class="h4 mb-3">Nuevo producto</h1>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('productos.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                @include('productos.form')

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary me-2">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        Guardar producto
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
