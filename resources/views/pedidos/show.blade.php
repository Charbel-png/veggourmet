@extends('layouts.panel')

@section('title', 'Detalle del pedido')

@section('content')
<div class="container-fluid py-4">

    <div class="row mb-3">
        <div class="col-md-8">
            <h1 class="h4 mb-1">Pedido #{{ $pedido->id_pedido }}</h1>
            <p class="text-muted mb-0">
                Detalle del pedido realizado en VegGourmet.
            </p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Volver a la lista
            </a>
        </div>
    </div>

    @php
        $cliente = $pedido->cliente;
        $nombreCliente = $cliente
            ? trim(($cliente->nombre ?? '') . ' ' . ($cliente->ap_paterno ?? '') . ' ' . ($cliente->ap_materno ?? ''))
            : 'Mostrador / sin registrar';
    @endphp

    <div class="row">
        <div class="col-lg-8 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0"
                     style="background: linear-gradient(90deg,#e9f8f0,#ffffff);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase small text-muted">Resumen</span>
                            <h2 class="h5 mb-0">Información del pedido</h2>
                        </div>
                        <span class="badge rounded-pill px-3 py-2"
                              style="background-color:#1987541a;color:#198754;">
                            {{ $pedido->estado->nombre ?? 'Sin estado' }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Cliente</p>
                            <p class="fw-semibold mb-0">{{ $nombreCliente }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1 text-muted small">Fecha</p>
                            <p class="fw-semibold mb-0">
                                {{ optional($pedido->fecha)->format('d/m/Y H:i') ?? $pedido->fecha }}
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1 text-muted small">Tipo</p>
                            <p class="fw-semibold mb-0">{{ $pedido->tipo }}</p>
                        </div>
                    </div>

                    <hr>

                    <h3 class="h6 mb-3">Productos del pedido</h3>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead style="background-color:#f5f7fb;">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center" style="width:120px;">Cantidad</th>
                                    <th class="text-end" style="width:140px;">Precio unitario</th>
                                    <th class="text-end" style="width:140px;">Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pedido->detalles as $detalle)
                                    <tr>
                                        <td>
                                            {{ $detalle->producto->nombre ?? 'Producto eliminado' }}
                                        </td>
                                        <td class="text-center">
                                            {{ rtrim(rtrim($detalle->cantidad, '0'), '.') }}
                                        </td>
                                        <td class="text-end">
                                            ${{ number_format($detalle->producto->precio_venta ?? 0, 2) }}
                                        </td>
                                        <td class="text-end">
                                            ${{ number_format($detalle->importe_calculado ?? 0, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No hay productos asociados a este pedido.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white border-0">
                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <ul class="list-group list-group-flush small">
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span>Subtotal</span>
                                    <span class="fw-semibold">
                                        ${{ number_format($subtotal, 2) }}
                                    </span>
                                </li>
                                {{-- aquí podrías agregar IVA, descuentos, etc. --}}
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <span class="fw-semibold">Total</span>
                                    <span class="fw-bold text-success">
                                        ${{ number_format($total, 2) }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Puedes usar esta columna para notas, estado, etc. --}}
        <div class="col-lg-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h3 class="h6 mb-3">Información adicional</h3>
                    <p class="small text-muted mb-2">
                        Aquí puedes agregar comentarios del pedido, instrucciones especiales
                        o información de entrega (por ejemplo, dirección para Delivery).
                    </p>
                    <p class="small text-muted mb-0">
                        Más adelante podemos ligar aquí el historial de cambios de estado
                        (pendiente, pagado, entregado, cancelado).
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
