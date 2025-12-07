@extends('layouts.app')

@section('title', 'Ingredientes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Ingredientes</h1>
        <a href="{{ route('ingredientes.create') }}" class="btn btn-primary">Nuevo ingrediente</a>
    </div>

    @if($ingredientes->isEmpty())
        <p>No hay ingredientes registrados.</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Unidad</th>
                <th>Activo</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ingredientes as $ing)
                <tr>
                    <td>{{ $ing->nombre }}</td>
                    <td>{{ $ing->unidad->nombre ?? '-' }}</td>
                    <td>{{ $ing->activo ? 'Sí' : 'No' }}</td>
                    <td class="text-end">
                        <a href="{{ route('ingredientes.edit', $ing) **}}" class="btn btn-sm btn-warning">
                            Editar
                        </a>
                        <form action="{{ route('ingredientes.destroy', $ing) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('¿Eliminar este ingrediente?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $ingredientes->links() }}
    @endif
@endsection
