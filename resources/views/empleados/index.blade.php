@extends('layouts.panel')

@section('title', 'Empleados')

@section('content')
<div class="d-flex align-items-center mb-3">
    <h1 class="h3 mb-0">Empleados</h1>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <span class="fw-semibold">Listado de empleados</span>
        <a href="{{ route('empleados.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Puesto</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->nombre }}</td>
                        <td>{{ $empleado->correo }}</td>
                        <td>
                            {{-- solo nombre del puesto --}}
                            @if(method_exists($empleado, 'puesto') && $empleado->puesto)
                                {{ $empleado->puesto->nombre }}
                            @else
                                {{ $empleado->puesto ?? 'Sin puesto' }}
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('empleados.edit', $empleado) }}"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('empleados.destroy', $empleado) }}"
                                  method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('¿Eliminar empleado?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            No hay empleados registrados.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
