@extends('layouts.panel')

@section('title', 'Mi carrito')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h3 mb-0">Mi carrito</h1>
        <p class="text-muted mb-0">Revisa los productos antes de confirmar tu pedido.</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        @if(empty($cart))
            <div class="p-4 text-center text-muted">
                Tu carrito está vacío.
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio unitario</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
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
                                    <form action="{{ route('cliente.carrito.remove', $item['id']) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('¿Eliminar del carrito?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
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

            <div class="p-3 d-flex justify-content-between">
                <form method="POST" action="{{ route('cliente.carrito.clear') }}">
                    @csrf
                    <button class="btn btn-outline-danger"
                            onclick="return confirm('¿Vaciar carrito?')">
                        Vaciar carrito
                    </button>
                </form>

                {{-- Aquí más adelante puedes poner el botón "Confirmar pedido" --}}
                <button class="btn btn-success" disabled>
                    Confirmar pedido (por implementar)
                </button>
            </div>
        @endif
    </div>
</div>
@endsection
