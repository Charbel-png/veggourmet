@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Productos</h1>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">Nuevo producto</a>
    </div>

    @if($productos->isEmpty())
        <p>No hay productos registrados.</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->id_producto }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->categoria->nombre ?? '-' }}</td>
                    <td>{{ $producto->estado ? 'Activo' : 'Inactivo' }}</td>
                    <td class="text-end">
                        <a href="{{ route('productos.edit', $producto) }}"
                           class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        <form action="{{ route('productos.destroy', $producto) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $productos->links() }}
    @endif
@endsection
