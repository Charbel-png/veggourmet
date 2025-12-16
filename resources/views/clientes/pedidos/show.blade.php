@extends('layouts.panel')

@section('title', 'Detalle del pedido')

@section('content')
<h1 class="h3 mb-3">Detalle del pedido</h1>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') }}</p>
        <p><strong>Estado:</strong> {{ $pedido->estado }}</p>
        <p><strong>Tipo:</strong> {{ ucfirst($pedido->tipo) }}</p>
    </div>
</div>

<div class="card shadow-sm border-0 mt-3">
    <div class="card-body">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th class="text-end">Precio</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detalles as $d)
                <tr>
                    <td>{{ $d->nombre }}</td>
                    <td>{{ $d->cantidad }}</td>
                    <td class="text-end">${{ number_format($d->precio_venta, 2) }}</td>
                    <td class="text-end">${{ number_format($d->cantidad * $d->precio_venta, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td class="text-end fw-bold">${{ number_format($total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<a href="{{ route('clientes.pedidos.index') }}" class="btn btn-secondary mt-3">
    <i class="bi bi-arrow-left"></i> Regresar al historial
</a>
@endsection
