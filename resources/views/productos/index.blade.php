@extends('layouts.panel')

@section('title', 'Productos')

@section('content')
    <h1 class="h4 mb-3">Productos</h1>

    @if(session('success'))
        <div class="alert alert-success py-2">
            {{ session('success') }}
        </div>
    @endif

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
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Stock mínimo</th>
                                <th class="text-center">Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                                <tr>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                                    <td class="text-center">
                                        {{ optional($producto->inventario)->stock ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ optional($producto->inventario)->stock_minimo ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        {{ $producto->estado == 1 ? 'Activo' : 'Inactivo' }}
                                    </td>
                                    <td class="text-end">
                                        @if(in_array(auth()->user()->tipo, ['admin', 'operador']))
                                            {{-- Editar --}}
                                            <a href="{{ route('productos.edit', $producto) }}"
                                               class="btn btn-sm btn-outline-primary me-1"
                                               title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            {{-- Eliminar --}}
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

                {{-- Paginación simple, sin texto "Showing 1 to..." --}}
                <div class="mt-3 d-flex justify-content-center">
                    {{ $productos->links('pagination::simple-bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
