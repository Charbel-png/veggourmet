@extends('layouts.app')

@section('title', 'Registro de cliente')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <h1 class="h4 mb-3 text-center">Registro de cliente</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
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
                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       class="form-control"
                       required>
            </div>

            <button class="btn btn-primary w-100 mb-3" type="submit">
                Registrarme
            </button>

            <div class="text-center">
                <small>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></small>
            </div>
        </form>
    </div>
</div>
@endsection
