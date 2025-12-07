@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">Nuevo cliente</a>
    </div>

    @if($clientes->isEmpty())
        <p>No hay clientes registrados.</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha de registro</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>
                        {{ $cliente->nombre }}
                        {{ $cliente->email }}
                        {{ $cliente->ap_paterno }}
                        {{ $cliente->ap_materno }}
                        {{ optional($cliente->created_at)->format('d/m/Y') }}
                    </td>
                    <td class="text-end">
                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        <form action="{{ route('clientes.destroy', $cliente) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('¿Eliminar este cliente?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $clientes->links() }}
    @endif
@endsection
