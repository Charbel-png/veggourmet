@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Receta de: {{ $producto->nombre }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('recetas.create', $producto) }}" class="btn btn-primary mb-3">
        Agregar ingrediente
    </a>

    @if($producto->ingredientes->isEmpty())
        <p>No hay ingredientes definidos para esta receta.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ingrediente</th>
                    <th>Unidad</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($producto->ingredientes as $ing)
                    <tr>
                        <td>{{ $ing->nombre }}</td>
                        <td>{{ $ing->unidad->abreviatura ?? '-' }}</td>
                        <td>{{ $ing->pivot->cantidad }}</td>
                        <td>
                            <a href="{{ route('recetas.edit', [$producto, $ing]) }}" class="btn btn-sm btn-warning">
                                Editar
                            </a>

                            <form action="{{ route('recetas.destroy', [$producto, $ing]) }}"
                                  method="POST"
                                  style="display:inline-block"
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
</div>
@endsection