@extends('layouts.panel')

@section('title', 'Solicitudes de acceso')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h3 mb-0">Solicitudes</h1>
        <small class="text-muted">Control de solicitudes de administradores y operadores.</small>
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h5 class="mb-0">Listado de solicitudes</h5>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>NOMBRE</th>
                        <th>CORREO</th>
                        <th>ROL SOLICITADO</th>
                        <th>ESTADO</th>
                        <th>FECHA</th>
                        <th class="text-end">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-capitalize">{{ $user->tipo }}</td>
                            <td>
                                @if($user->estado === 'pendiente')
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @elseif($user->estado === 'aprobado')
                                    <span class="badge bg-success">Aprobado</span>
                                @else
                                    <span class="badge bg-secondary">Rechazado</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                {{-- ESTADO: PENDIENTE -> aprobar / rechazar --}}
                                @if($user->estado === 'pendiente')
                                    <form action="{{ route('admin.solicitudes.aprobar', $user) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-success btn-sm"
                                                title="Aprobar solicitud">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.solicitudes.rechazar', $user) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Rechazar esta solicitud?');">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-outline-danger btn-sm"
                                                title="Rechazar solicitud">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>

                                {{-- ESTADO: YA PROCESADA -> ver / eliminar --}}
                                @else
                                    {{-- Ver detalles: de momento te llevo al listado de empleados,
                                         puedes afinar luego el filtro por correo si quieres --}}
                                    <a href="{{ route('empleados.index') }}"
                                       class="btn btn-outline-primary btn-sm"
                                       title="Ver / editar empleado">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <form action="{{ route('admin.solicitudes.rechazar', $user) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Eliminar este registro de solicitud?');">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-outline-danger btn-sm"
                                                title="Eliminar registro">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No hay solicitudes registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
