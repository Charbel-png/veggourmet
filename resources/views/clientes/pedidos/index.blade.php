@extends('layouts.panel')

@section('title', 'Mis pedidos')

@section('content')
<h1 class="h3 mb-3">Historial de pedidos</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($pedidos->isEmpty())
    <div class="alert alert-info">Aún no has realizado pedidos.</div>
@else
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Tipo</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $p)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge 
                            @if(strtolower($p->estado) == 'cancelado') bg-danger
                            @elseif(strtolower($p->estado) == 'entregado') bg-success
                            @else bg-secondary @endif">
                            {{ $p->estado }}
                        </span>
                    </td>
                    <td>{{ ucfirst($p->tipo) }}</td>
                    <td class="text-end">
                        <a href="{{ route('clientes.pedidos.show', $p->id_pedido) }}"
                        class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-eye"></i> Ver
                        </a>

                        @if(!in_array(strtolower($p->estado), ['entregado', 'cancelado', 'devuelto']))
                        <form action="{{ route('clientes.pedidos.cancelar', $p->id_pedido) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('¿Cancelar este pedido?');">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
