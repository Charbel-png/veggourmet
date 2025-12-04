@extends('layouts.app')

@section('title', 'Receta de ' . $producto->nombre)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1>Receta de: {{ $producto->nombre }}</h1>
            <p class="text-muted">ID producto: {{ $producto->id_producto }}</p>
        </div>

        <div>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary me-2">
                Volver a productos
            </a>
            <a href="{{ route('recetas.create', $producto) }}" class="btn btn-primary">
                Agregar ingrediente
            </a>
        </div>
    </div>

    @if($recetas->isEmpty())
        <p>Este producto aún no tiene ingredientes definidos.</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID ingrediente</th>
                <th>Ingrediente</th>
                <th>Cantidad</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($recetas as $rec)
                <tr>
                    <td>{{ $rec->id_ingrediente }}</td>
                    <td>{{ $rec->ingrediente->nombre ?? '-' }}</td>
                    <td>{{ $rec->cantidad }}</td>
                    <td class="text-end">
                        <a href="{{ route('recetas.edit', [$producto, $rec->id_ingrediente]) }}"
                           class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        <form action="{{ route('recetas.destroy', [$producto, $rec->id_ingrediente]) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('¿Eliminar este ingrediente de la receta?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
