@extends('layouts.panel')

@section('title', 'Inventario')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">Inventario</h1>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Buscador --}}
    <form method="GET" action="{{ route('inventario.index') }}" class="row g-2 mb-3">
        <div class="col-sm-6 col-md-4">
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   class="form-control"
                   placeholder="Buscar por nombre de producto">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-secondary btn-sm" type="submit">Buscar</button>
        </div>
        <div class="col-auto">
            <a href="{{ route('inventario.index') }}" class="btn btn-link btn-sm">Limpiar</a>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if ($inventarios->isEmpty())
                <p class="text-muted mb-0">No hay productos en inventario.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Stock mínimo</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventarios as $inv)
                                <tr>
                                    <td>{{ $inv->producto->nombre ?? 'Sin nombre' }}</td>
                                    <td>{{ $inv->producto->categoria->nombre ?? 'Sin categoría' }}</td>
                                    <td class="text-center">{{ $inv->stock }}</td>
                                    <td class="text-center">{{ $inv->stock_minimo }}</td>
                                    <td class="text-end">
                                        {{-- IMPORTANTE: usar id_producto, NO id_inventario --}}
                                        <a href="{{ route('inventario.edit', $inv->id_producto) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $inventarios->links('pagination::simple-bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
