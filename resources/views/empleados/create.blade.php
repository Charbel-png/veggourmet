@extends('layouts.panel')

@section('title', 'Nuevo empleado')

@section('content')
    <h1 class="h4 mb-3">Nuevo empleado</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li class="small">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('empleados.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Nombre *</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Apellido paterno *</label>
                <input type="text" name="apellido_paterno" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Apellido materno</label>
                <input type="text" name="apellido_materno" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Correo electrónico *</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Puesto *</label>
                <select name="id_puesto" class="form-select" required>
                    <option value="">Seleccione un puesto</option>
                    @foreach($puestos as $puesto)
                        <option value="{{ $puesto->id_puesto }}">{{ $puesto->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button class="btn btn-success">
            Guardar empleado
        </button>
    </form>
@endsection
