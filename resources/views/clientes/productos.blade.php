@extends('layouts.panel')

@section('title', 'Productos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h3 mb-0">Productos disponibles</h1>
        <p class="text-muted mb-0">
            Elige los productos que deseas añadir a tu pedido.
        </p>
    </div>
</div>

<div class="row">
    {{-- Columna de productos --}}
    <div class="col-lg-9">
        <div class="row g-3">
            @forelse($productos as $producto)
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 shadow-sm border-0">
                        {{-- Imagen --}}
                        @php
                            $img = $producto->imagen;

                            if ($img) {
                                // Si NO comienza con http/https, asumimos ruta interna dentro de /public
                                if (!preg_match('#^https?://#', $img)) {
                                    $img = asset($img);   // ej: img/productos/agua_pepino.jpg
                                }
                            } else {
                                // Sin imagen => placeholder
                                $img = asset('img/producto-placeholder.png');
                            }

                            $stock = optional($producto->inventario)->stock ?? 0;
                        @endphp

                        <img src="{{ $img }}"
                             class="card-img-top"
                             alt="{{ $producto->nombre }}"
                             style="object-fit: cover; height: 170px;">

                        <div class="card-body d-flex flex-column">
                            <small class="text-muted">
                                {{ optional($producto->categoria)->nombre ?? 'Sin categoría' }}
                            </small>

                            <h5 class="card-title mb-1">{{ $producto->nombre }}</h5>

                            <p class="fs-5 fw-bold mb-1">
                                ${{ number_format($producto->precio_venta ?? 0, 2) }}
                            </p>

                            <p class="text-muted mb-1">
                                Stock: {{ $stock }}
                            </p>

                            {{-- Formulario añadir al carrito --}}
                            <form method="POST"
                                  action="{{ route('clientes.carrito.add', $producto->id_producto) }}"
                                  class="mt-auto">
                                @csrf

                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text">Cant.</span>
                                    <input type="number"
                                           name="cantidad"
                                           min="1"
                                           max="{{ $stock > 0 ? $stock : null }}"
                                           value="1"
                                           class="form-control"
                                           {{ $stock <= 0 ? 'disabled' : '' }}>
                                </div>

                                <button type="submit"
                                        class="btn btn-success w-100"
                                        {{ $stock <= 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-cart-plus me-1"></i>
                                    {{ $stock <= 0 ? 'Sin stock' : 'Añadir al carrito' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        No hay productos disponibles por el momento.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Columna de mini–carrito --}}
    <div class="col-lg-3 mt-3 mt-lg-0">
        @php
            // Aseguramos que usemos la misma clave que CartController: 'cart'
            $cart = $cart ?? session('cart', []);
            $total = 0;
        @endphp

        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white">
                Mi pedido
            </div>
            <div class="card-body">
                @if(empty($cart))
                    <p class="text-muted mb-0">
                        Todavía no has agregado productos.
                    </p>
                @else
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($cart as $item)
                            @php
                                $subtotal = $item['precio'] * $item['cantidad'];
                                $total += $subtotal;
                            @endphp

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">{{ $item['nombre'] }}</div>
                                    <small class="text-muted">
                                        x{{ $item['cantidad'] }}
                                        &middot;
                                        ${{ number_format($item['precio'], 2) }}
                                    </small>
                                </div>
                                <span class="fw-semibold">
                                    ${{ number_format($subtotal, 2) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="d-flex justify-content-between fw-bold mb-3">
                        <span>Total:</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>

                    <a href="{{ route('clientes.carrito') }}"
                       class="btn btn-outline-success w-100 mb-2">
                        Ver carrito completo
                    </a>

                    <form method="POST" action="{{ route('clientes.carrito.clear') }}">
                        @csrf
                        <button type="submit"
                                class="btn btn-outline-danger w-100 btn-sm"
                                onclick="return confirm('¿Vaciar carrito?')">
                            Vaciar carrito
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
