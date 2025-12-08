@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Productos</h1>

        @if(in_array(auth()->user()->tipo, ['admin', 'operador']))
            <a href="{{ route('productos.create') }}"
               class="btn btn-primary"
               title="Nuevo producto">
                <i class="bi bi-plus-lg"></i>
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($productos->isEmpty())
        <p>No hay productos registrados.</p>
    @else
        <div class="card shadow-sm border-0">
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                    <tr>
                        {{-- Sin ID --}}
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Existencia</th>
                        <th>Stock mínimo</th>
                        <th>Precio venta</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productos as $producto)
                        @php
                            $inv = $producto->inventario;
                        @endphp
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                            <td>{{ $inv->stock ?? 0 }}</td>
                            <td>{{ $inv->stock_minimo ?? 0 }}</td>
                            <td>${{ number_format($producto->precio_venta, 2) }}</td>
                            <td>{{ $producto->estado ? 'Activo' : 'Inactivo' }}</td>

                            <td class="text-end">
                                {{-- Editar: icono solo --}}
                                @if(in_array(auth()->user()->tipo, ['admin','operador']))
                                    <a href="{{ route('productos.edit', $producto) }}"
                                       class="btn btn-warning btn-sm me-1"
                                       title="Editar producto">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                @endif

                                {{-- Eliminar solo para admin, icono solo --}}
                                @if(auth()->user()->tipo === 'admin')
                                    <form action="{{ route('productos.destroy', $producto) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Eliminar producto">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $productos->links() }}
        </div>
    @endif
@endsection
