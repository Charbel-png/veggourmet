@extends('layouts.panel')

@section('title', 'Mi carrito')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Mi carrito</h1>

    {{-- ✅ Botón para regresar al catálogo --}}
    <a href="{{ route('clientes.productos') }}"
    class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Seguir comprando
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if(empty($cart))
    <div class="alert alert-info">
        Tu carrito está vacío. Ve al
        <a href="{{ route('clientes.productos') }}">catálogo</a>
        para agregar productos.
    </div>
@else
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio</th>
                        <th class="text-end">Subtotal</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $idProducto => $item)
                        <tr>
                            <td>{{ $item['nombre'] }}</td>
                            <td class="text-center">{{ $item['cantidad'] }}</td>
                            <td class="text-end">
                                ${{ number_format($item['precio'], 2) }}
                            </td>
                            <td class="text-end">
                                ${{ number_format($item['precio'] * $item['cantidad'], 2) }}
                            </td>
                            <td class="text-end">
                                <form action="{{ route('clientes.carrito.remove', $idProducto) }}"
                                    method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-outline-danger btn-sm"
                                            title="Quitar del carrito">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th class="text-end">
                            ${{ number_format($total, 2) }}
                        </th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-between flex-wrap gap-2">
            {{-- Vaciar carrito --}}
            <form action="{{ route('clientes.carrito.clear') }}"
                method="POST">
                @csrf
                <button type="submit"
                        class="btn btn-outline-danger"
                        onclick="return confirm('¿Vaciar carrito completo?')">
                    Vaciar carrito
                </button>
            </form>

            {{-- Confirmar pedido --}}
            <form action="{{ route('clientes.carrito.confirmar') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    Confirmar pedido
                </button>
            </form>
        </div>
    </div>
@endif
@endsection
