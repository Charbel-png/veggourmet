@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Productos</h1>

        {{-- Botón nuevo producto solo con ícono --}}
        <a href="{{ route('productos.create') }}"
           class="btn btn-primary"
           title="Nuevo producto">
            <i class="bi bi-plus-circle"></i>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($productos->isEmpty())
        <p>No hay productos registrados.</p>
    @else
        <table class="table table-striped align-middle">
            <thead>
            <tr>
                {{-- 👇 Ya NO mostramos ID --}}
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                    <td>{{ $producto->estado ? 'Activo' : 'Inactivo' }}</td>
                    <td class="text-end">
                        {{-- Botón editar: solo ícono, texto en tooltip --}}
                        <a href="{{ route('productos.edit', $producto) }}"
                           class="btn btn-warning btn-sm"
                           title="Editar producto">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        {{-- Botón eliminar: solo ícono, texto en tooltip --}}
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
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $productos->links() }}
    @endif
@endsection
