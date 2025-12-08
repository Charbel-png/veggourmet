@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Categorías</h1>

    @if(auth()->user()->tipo === 'admin')
        <a href="{{ route('categorias.create') }}"
           class="btn btn-success"
           title="Nueva categoría">
            <i class="bi bi-plus-lg"></i>
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    {{-- No mostramos ID --}}
                    <th>Nombre</th>
                    <th>Descripción</th>
                    @if(auth()->user()->tipo === 'admin')
                        <th class="text-end">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nombre }}</td>
                        <td>{{ $categoria->descripcion }}</td>
                        @if(auth()->user()->tipo === 'admin')
                            <td class="text-end">
                                <a href="{{ route('categorias.edit', $categoria) }}"
                                   class="btn btn-sm btn-warning"
                                   title="Editar categoría">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('categorias.destroy', $categoria) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Eliminar esta categoría?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Eliminar categoría">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">
                            No hay categorías registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categorias->hasPages())
        <div class="card-footer">
            {{ $categorias->links() }}
        </div>
    @endif
</div>
@endsection
