@extends('layouts.panel')

@section('title', 'Empleados')

@section('content')
<div class="d-flex align-items-center mb-3">
    <h1 class="h3 mb-0">Empleados</h1>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <span class="fw-semibold">Listado de empleados</span>
        <a href="{{ route('empleados.create') }}" class="btn btn-success btn-sm" title="Agregar empleado">
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
                        <th>Estatus</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->nombre }}</td>
                        <td>{{ $empleado->email }}</td>
                        <td>
                            @if($empleado->puesto)
                                {{ $empleado->puesto->nombre }}
                            @else
                                <span class="text-muted">Sin puesto</span>
                            @endif
                        </td>
                        <td>
                            @if($empleado->aprobado)
                                <span class="badge bg-success">Aprobado</span>
                            @else
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @endif
                        </td>
                        <td class="text-end">
                            {{-- Editar --}}
                            <a href="{{ route('empleados.edit', $empleado) }}"
                               class="btn btn-outline-primary btn-sm"
                               title="Editar empleado">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            {{-- Aprobar / desaprobar --}}
                            @if(! $empleado->aprobado)
                                <form action="{{ route('empleados.aprobar', $empleado) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="btn btn-sm btn-success"
                                            title="Aprobar empleado">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('empleados.rechazar', $empleado) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-secondary"
                                            title="Marcar como no aprobado">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            @endif

                            {{-- Eliminar --}}
                            <form action="{{ route('empleados.destroy', $empleado) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('¿Eliminar empleado?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                        title="Eliminar empleado">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
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
