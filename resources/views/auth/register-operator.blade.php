@extends('layouts.app')

@section('title', 'Registrar operador')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-3 text-center">Registrar operador</h1>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('operadores.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre completo</label>
                            <input type="text"
                                   name="nombre"
                                   id="nombre"
                                   class="form-control"
                                   value="{{ old('nombre') }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control"
                                   value="{{ old('email') }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                Confirmar contraseña
                            </label>
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('empleados.index') }}"
                               class="btn btn-outline-secondary"
                               title="Cancelar">
                                <i class="bi bi-x-circle"></i>
                            </a>

                            <button type="submit"
                                    class="btn btn-primary"
                                    title="Guardar operador">
                                <i class="bi bi-check2-circle"></i>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
