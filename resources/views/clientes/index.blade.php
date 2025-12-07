@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Clientes</h1>

        @if(auth()->user()->tipo === 'admin')
            {{-- Botón nuevo cliente solo con ícono --}}
            <a href="{{ route('clientes.create') }}"
               class="btn btn-primary"
               title="Nuevo cliente">
                <i class="bi bi-plus-circle"></i>
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($clientes->isEmpty())
        <p>No hay clientes registrados.</p>
    @else
        <table class="table table-striped align-middle">
            <thead>
            <tr>
                {{-- 👇 NO mostramos ID --}}
                <th>Nombre completo</th>
                <th class="text-end">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>
                        {{ $cliente->nombre }}
                        {{ $cliente->ap_paterno }}
                        {{ $cliente->ap_materno }}
                    </td>
                    <td class="text-end">
                        {{-- Editar (admin + operador) --}}
                        @if(in_array(auth()->user()->tipo, ['admin','operador']))
                            <a href="{{ route('clientes.edit', $cliente) }}"
                               class="btn btn-warning btn-sm"
                               title="Editar cliente">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        @endif

                        {{-- Eliminar solo admin --}}
                        @if(auth()->user()->tipo === 'admin')
                            <form action="{{ route('clientes.destroy', $cliente) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        title="Eliminar cliente">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $clientes->links() }}
    @endif
@endsection
