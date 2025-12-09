@extends('layouts.panel')

@section('title', 'Clientes')

@section('content')
    <h1 class="h4 mb-3">Clientes</h1>

    @if(session('success'))
        <div class="alert alert-success py-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Listado de clientes</h5>

                @if(in_array(auth()->user()->tipo, ['admin', 'operador']))
                    <a href="{{ route('clientes.create') }}"
                       class="btn btn-success btn-sm"
                       title="Nuevo cliente">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                @endif
            </div>

            @if($clientes->isEmpty())
                <p class="text-muted mb-0">Aún no hay clientes registrados.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Ap. paterno</th>
                                <th>Ap. materno</th>
                                <th>Correo</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->nombre }}</td>
                                    <td>{{ $cliente->ap_paterno }}</td>
                                    <td>{{ $cliente->ap_materno }}</td>
                                    <td>{{ $cliente->email ?? '-' }}</td>
                                    <td class="text-end">
                                        @if(in_array(auth()->user()->tipo, ['admin','operador']))
                                            <a href="{{ route('clientes.edit', $cliente) }}"
                                               class="btn btn-sm btn-outline-primary me-1"
                                               title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('clientes.destroy', $cliente) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Eliminar este cliente?');">
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

                <div class="mt-3 d-flex justify-content-center">
                    {{ $clientes->links('pagination::simple-bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
