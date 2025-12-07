@extends('layouts.app')

@section('title', 'Productos disponibles')

@section('content')
    <h1 class="mb-4">Productos disponibles</h1>

    @if($productos->isEmpty())
        <p>No hay productos disponibles en este momento.</p>
    @else
        <div class="row g-3">
            @foreach($productos as $producto)
                <div class="col-md-3">
                    <div class="card h-100">

                        {{-- Imagen del producto (o una por defecto) --}}
                        @php
                            // Si el producto no tiene imagen, usamos default.jpg
                            $archivoImagen = $producto->imagen ?: 'default.jpg';
                        @endphp

                        <img src="{{ asset('img/productos/'.$archivoImagen) }}"
                             class="card-img-top"
                             alt="{{ $producto->nombre }}">

                        <div class="card-body d-flex flex-column">
                            {{-- Nombre --}}
                            <h5 class="card-title">{{ $producto->nombre }}</h5>

                            {{-- Descripción (si existe) --}}
                            <p class="card-text small">
                                {{ $producto->descripcion ?? 'Sin descripción' }}
                            </p>

                            {{-- Aquí más info si quieres (precio, categoría, etc.) --}}
                            @if(!empty($producto->precio_venta))
                                <p class="fw-bold mb-2">
                                    ${{ number_format($producto->precio_venta, 2) }} MXN
                                </p>
                            @endif

                            {{-- Formulario de cantidad (aún sin lógica de carrito) --}}
                            <form class="mt-auto">
                                <div class="mb-2">
                                    <label class="form-label mb-1">Cantidad</label>
                                    <input type="number"
                                           min="1"
                                           value="1"
                                           class="form-control form-control-sm">
                                </div>

                                <button type="button" class="btn btn-sm btn-success w-100">
                                    Añadir al pedido
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="mt-3">
            {{ $productos->links() }}
        </div>
    @endif
@endsection
