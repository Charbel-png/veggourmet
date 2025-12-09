@extends('layouts.panel')

@section('title', 'Pedidos')

@section('content')
    <h1 class="h4 mb-3">Pedidos</h1>

    @if(session('success'))
        <div class="alert alert-success py-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Historial de pedidos</h5>

                {{-- SOLO cliente puede crear; admin/operador solo consultan/eliminan --}}
                @if(auth()->user()->tipo === 'cliente')
                    <a href="{{ route('pedidos.create') }}"
                       class="btn btn-success btn-sm"
                       title="Nuevo pedido">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                @endif
            </div>

            @if($pedidos->isEmpty())
                <p class="text-muted mb-0">Aún no hay pedidos registrados.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Tipo</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->cliente->nombre ?? 'Sin cliente' }}</td>
                                    <td>{{ $pedido->fecha }}</td>
                                    <td>{{ $pedido->estado->nombre ?? '-' }}</td>
                                    <td>{{ $pedido->tipo }}</td>
                                    <td class="text-end">
                                        {{-- Ver detalle (todos) --}}
                                        <a href="{{ route('pedidos.show', $pedido) }}"
                                           class="btn btn-sm btn-outline-primary me-1"
                                           title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Eliminar solo admin / operador --}}
                                        @if(in_array(auth()->user()->tipo, ['admin', 'operador']))
                                            <form action="{{ route('pedidos.destroy', $pedido) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Eliminar este pedido?');">
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
                    {{ $pedidos->links('pagination::simple-bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
