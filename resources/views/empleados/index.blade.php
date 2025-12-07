<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Empleados</h1>

    <div class="d-flex gap-2">
        {{-- Nuevo empleado --}}
        <a href="{{ route('empleados.create') }}"
           class="btn btn-primary"
           title="Nuevo empleado">
            <i class="bi bi-person-plus-fill"></i>
        </a>

        {{-- Nuevo operador (sólo admin) --}}
        @if(auth()->user()->tipo === 'admin')
            <a href="{{ route('operadores.create') }}"
               class="btn btn-secondary"
               title="Registrar operador">
               <i class="bi bi-person-gear"></i>
            </a>
        @endif
    </div>
</div>
