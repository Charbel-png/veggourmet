@extends('layouts.panel')

@section('title', 'Editar inventario')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">
        Editar inventario:
        <small class="text-muted">{{ $inventario->producto->nombre ?? 'Producto' }}</small>
    </h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups...</strong> Revisa los campos.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('inventario.update', $inventario) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Stock actual *</label>
            <input type="number"
                   step="0.01"
                   min="0"
                   name="stock"
                   class="form-control @error('stock') is-invalid @enderror"
                   value="{{ old('stock', $inventario->stock) }}">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Stock mínimo *</label>
            <input type="number"
                   step="0.01"
                   min="0"
                   name="stock_minimo"
                   class="form-control @error('stock_minimo') is-invalid @enderror"
                   value="{{ old('stock_minimo', $inventario->stock_minimo) }}">
            @error('stock_minimo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                Guardar cambios
            </button>
        </div>
    </form>
</div>
@endsection
