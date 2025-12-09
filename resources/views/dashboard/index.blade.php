@extends('layouts.panel')

@section('title', 'Dashboard general')

@section('content')
<div class="container-fluid">

    {{-- Tarjetas de resumen --}}
    <div class="row g-3 mb-4">

        {{-- Productos totales --}}
        <div class="col-md-3">
            <div class="card border-0 text-white shadow-sm" style="background:#04284A;">
                <div class="card-body">
                    <div class="text-uppercase small mb-1">Productos totales</div>
                    <div class="fs-2 fw-bold">{{ $totalProductos }}</div>
                </div>
            </div>
        </div>

        {{-- Clientes registrados --}}
        <div class="col-md-3">
            <div class="card border-0 text-white shadow-sm" style="background:#F2A30F;">
                <div class="card-body">
                    <div class="text-uppercase small mb-1">Clientes registrados</div>
                    <div class="fs-2 fw-bold">{{ $totalClientes }}</div>
                </div>
            </div>
        </div>

        {{-- Pedidos --}}
        <div class="col-md-3">
            <div class="card border-0 text-white shadow-sm" style="background:#F26624;">
                <div class="card-body">
                    <div class="text-uppercase small mb-1">Pedidos</div>
                    <div class="fs-2 fw-bold">{{ $totalPedidos }}</div>
                </div>
            </div>
        </div>

        {{-- Stock bajo --}}
        <div class="col-md-3">
            <div class="card border-0 text-white shadow-sm" style="background:#D64545;">
                <div class="card-body">
                    <div class="text-uppercase small mb-1">Stock bajo</div>
                    <div class="fs-2 fw-bold">
                        {{ $productosMenorStock->count() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabla: productos con menor stock --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0">
            <h2 class="h5 mb-0">Productos con menor stock</h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Stock mínimo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productosMenorStock as $p)
                            <tr>
                                <td>{{ $p->nombre }}</td>
                                <td class="text-center">{{ $p->stock }}</td>
                                <td class="text-center">{{ $p->stock_minimo }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    No hay productos con stock bajo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
