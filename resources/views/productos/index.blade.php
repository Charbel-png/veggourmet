@extends('layouts.panel')

@section('title', 'Productos')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">Productos</h1>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Buscador --}}
    <form method="GET" action="{{ route('productos.index') }}" class="row g-2 mb-3">
        <div class="col-sm-6 col-md-4">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                class="form-control"
                placeholder="Buscar por nombre o descripción">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-secondary btn-sm">
                Buscar
            </button>
        </div>
        <div class="col-auto">
            <a href="{{ route('productos.index') }}" class="btn btn-link btn-sm">
                Limpiar
            </a>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Listado de productos</h5>

                @if(in_array(auth()->user()->tipo, ['admin', 'operador']))
                    <a href="{{ route('productos.create') }}"
                       class="btn btn-success btn-sm"
                       title="Nuevo producto">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                @endif
            </div>

            @if($productos->isEmpty())
                <p class="text-muted mb-0">Aún no hay productos registrados.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th class="text-end">Precio venta</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Stock mínimo</th>
                                <th class="text-center">Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                                <tr>
                                    {{-- Imagen (acepta URL externa o ruta interna tipo img/productos/...) --}}
                                    <td>
                                        @php
                                            $img = $producto->imagen;

                                            if ($img) {
                                                // Si NO comienza con http/https, asumimos ruta interna y aplicamos asset()
                                                if (!preg_match('#^https?://#', $img)) {
                                                    $img = asset($img);
                                                }
                                            }
                                        @endphp

                                        @if($img)
                                            <img src="{{ $img }}"
                                                 alt="{{ $producto->nombre }}"
                                                 class="img-thumbnail"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Sin imagen</span>
                                        @endif
                                    </td>

                                    {{-- Datos básicos --}}
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>

                                    {{-- Precio --}}
                                    <td class="text-end">
                                        ${{ number_format($producto->precio_venta, 2) }}
                                    </td>

                                    {{-- Stock (desde inventario, solo vista) --}}
                                    <td class="text-center">
                                        {{ optional($producto->inventario)->stock ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ optional($producto->inventario)->stock_minimo ?? 0 }}
                                    </td>

                                    {{-- Estado --}}
                                    <td class="text-center">
                                        <span class="badge rounded-pill {{ $producto->estado ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $producto->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="text-end">
                                        @if(in_array(auth()->user()->tipo, ['admin', 'operador']))
                                            {{-- Editar --}}
                                            <a href="{{ route('productos.edit', $producto) }}"
                                               class="btn btn-sm btn-outline-primary me-1"
                                               title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            {{-- Eliminar (baja lógica) --}}
                                            <form action="{{ route('productos.destroy', $producto) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Eliminar este producto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="mt-3 d-flex justify-content-center">
                    {{ $productos->links('pagination::simple-bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
