@extends('layouts.app')

@section('title', 'Editar empleado')

@section('content')
<h1 class="h3 mb-3">Editar empleado</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('empleados.update', $empleado) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" name="nombre" id="nombre"
                       class="form-control"
                       value="{{ old('nombre', $empleado->nombre) }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email"
                       class="form-control"
                       value="{{ old('email', $empleado->email) }}">
            </div>

            <div class="mb-3">
                <label for="id_puesto" class="form-label">Puesto</label>
                <select name="id_puesto" id="id_puesto" class="form-select">
                    @foreach($puestos as $puesto)
                        <option value="{{ $puesto->id_puesto }}"
                            @selected(old('id_puesto', $empleado->id_puesto) == $puesto->id_puesto)>
                            {{ $puesto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success" title="Guardar">
                    <i class="bi bi-check-lg"></i>
                </button>
                <a href="{{ route('empleados.index') }}" class="btn btn-secondary" title="Cancelar">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
