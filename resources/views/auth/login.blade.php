@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<div class="row justify-content-center">
    {{-- Bloque LOGIN --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h4 mb-3 text-center">Iniciar sesión</h1>

                @if($errors->has('email') || $errors->has('password'))
                    <div class="alert alert-danger">
                        {{ $errors->first('email') ?: $errors->first('password') }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="login_email" class="form-label">Correo electrónico</label>
                        <input type="email"
                               name="email"
                               id="login_email"
                               class="form-control"
                               value="{{ old('email') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="login_password" class="form-label">Contraseña</label>
                        <input type="password"
                               name="password"
                               id="login_password"
                               class="form-control"
                               required>
                    </div>

                    <button class="btn btn-primary w-100" type="submit">
                        Entrar
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Bloque REGISTRO CLIENTE --}}
    <div class="col-md-4 mb-4" id="registro">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h4 mb-3 text-center">Registro de cliente</h1>

                {{-- Aquí podrías mostrar errores específicos de registro si los separas en el controlador --}}

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="registro_nombre" class="form-label">Nombre completo</label>
                        <input type="text"
                               name="nombre"
                               id="registro_nombre"
                               class="form-control"
                               value="{{ old('nombre') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="registro_email" class="form-label">Correo electrónico</label>
                        <input type="email"
                               name="email"
                               id="registro_email"
                               class="form-control"
                               value="{{ old('email') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="registro_password" class="form-label">Contraseña</label>
                        <input type="password"
                               name="password"
                               id="registro_password"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="registro_password_confirmation" class="form-label">
                            Confirmar contraseña
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               id="registro_password_confirmation"
                               class="form-control"
                               required>
                    </div>

                    <button class="btn btn-success w-100" type="submit">
                        Registrarme como cliente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
