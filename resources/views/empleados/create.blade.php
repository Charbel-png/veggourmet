@extends('layouts.app')

@section('title', 'Nuevo empleado')

@section('content')
<h1 class="h3 mb-3">Nuevo empleado / operador</h1>

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
        <form action="{{ route('empleados.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" name="nombre" id="nombre"
                       class="form-control"
                       value="{{ old('nombre') }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email"
                       class="form-control"
                       value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label for="id_puesto" class="form-label">Puesto</label>
                <select name="id_puesto" id="id_puesto" class="form-select">
                    @foreach($puestos as $puesto)
                        <option value="{{ $puesto->id_puesto }}"
                            @selected(old('id_puesto') == $puesto->id_puesto)>
                            {{ $puesto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <hr>

            <p class="fw-bold mb-2">
                Datos de acceso (el empleado será operador):
            </p>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation"
                       id="password_confirmation" class="form-control">
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
