@extends('layouts.panel')

@section('title', 'Editar Inventario')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">Actualizar inventario</h1>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3">{{ $producto->nombre }}</h5>

            <form method="POST" action="{{ route('inventario.update', $producto->id_producto) }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Stock actual</label>
                        <input type="number" step="0.01" min="0"
                               name="stock"
                               value="{{ old('stock', $inventario->stock ?? 0) }}"
                               class="form-control @error('stock') is-invalid @enderror">
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Stock mínimo</label>
                        <input type="number" step="0.01" min="0"
                               name="stock_minimo"
                               value="{{ old('stock_minimo', $inventario->stock_minimo ?? 0) }}"
                               class="form-control @error('stock_minimo') is-invalid @enderror">
                        @error('stock_minimo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
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
    </div>
</div>
@endsection
