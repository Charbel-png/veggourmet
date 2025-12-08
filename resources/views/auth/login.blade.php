@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<style>
    .auth-bg {
        background: linear-gradient(180deg, #e9f7f0 0%, #ffffff 40%);
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .auth-card {
        max-width: 480px;
        width: 100%;
        background-color: #f7f7f7;
        border-radius: 18px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        overflow: hidden;
        border: none;
    }
    .auth-header {
        font-size: 1.4rem;
        font-weight: 700;
        color: #198754;
        text-align: center;
        padding-top: 1.5rem;
    }
    .auth-cta-btn {
        background-color: #198754;
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.03em;
        border: none;
        padding-block: 0.7rem;
    }
    .auth-cta-btn:hover {
        background-color: #146c43;
    }
    .auth-linkbar {
        background-color: #ffffff;
        border-top: 1px solid #ddd;
        padding: .75rem 1.5rem;
        font-size: .9rem;
        text-align: center;
    }
    .auth-linkbar a {
        color: #198754;
        font-weight: 500;
        text-decoration: none;
        margin-inline: .75rem;
    }
    .auth-linkbar a:hover {
        text-decoration: underline;
    }
    .form-control-auth {
        border-radius: 50px;
        padding-inline: 1.3rem;
        height: 44px;
    }
    .auth-label {
        font-size: .9rem;
        font-weight: 600;
    }
</style>

<div class="auth-bg">
    <div class="card auth-card">
        <div class="p-4 p-md-5">
            <div class="auth-header mb-3">Formulario de inicio de sesión</div>

            @if($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success py-2 small mb-3">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="auth-label" for="login_email">Correo electrónico *</label>
                    <input type="email"
                           id="login_email"
                           name="email"
                           class="form-control form-control-auth"
                           placeholder="Ingresa tu correo"
                           value="{{ old('email') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="auth-label" for="login_password">Contraseña *</label>
                    <input type="password"
                           id="login_password"
                           name="password"
                           class="form-control form-control-auth"
                           placeholder="Ingresa tu contraseña"
                           required>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                    <label class="form-check-label small" for="remember">
                        Recordarme
                    </label>
                </div>

                <button type="submit" class="btn btn-success w-100 auth-cta-btn">
                    INGRESAR
                </button>
            </form>

            <div class="auth-linkbar mt-4 rounded-pill">
                <span>¿No tienes una cuenta?</span>
                <a href="{{ route('register') }}">Regístrate</a>
            </div>
        </div>
    </div>
</div>
@endsection
