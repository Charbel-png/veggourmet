@extends('layouts.panel')

@section('title', 'Pedidos')

@section('content')
<h1 class="h3 mb-3">Pedidos registrados</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th class="text-end">Total</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $p)
                    <tr>
                        <td>{{ $p->cliente ?? '—' }}</td>
                        <td>{{ $p->fecha }}</td>
                        <td>{{ $p->tipo }}</td>
                        <td>{{ $p->estado }}</td>
                        <td class="text-end">
                            ${{ number_format($p->total, 2) }}
                        </td>
                        <td class="text-end">
                            {{-- Cambiar estado (incluye cancelar, devuelto, etc.) --}}
                            <form action="{{ route('pedidos.estado', $p->id_pedido) }}"
                                method="POST" class="d-inline">
                                @csrf
                                <div class="input-group input-group-sm d-inline-flex w-auto">
                                    <select name="id_estado" class="form-select form-select-sm">
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado->id_estado }}"
                                                @selected($estado->id_estado == $p->id_estado)>
                                                {{ $estado->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Actualizar estado">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                </div>
                            </form>
                            {{-- Ver detalles del pedido --}}
                            <a href="{{ route('pedidos.show', $p->id_pedido) }}"
                            class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
