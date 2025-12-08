@extends('layouts.app')

@section('title', 'Registro de usuario')

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
        max-width: 480px; /* mismo ancho que login */
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
        color: #198754; /* verde VegGourmet */
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
            <div class="auth-header mb-2">Registro de usuario</div>
            <p class="small text-muted mb-3 text-center">
                Completa tus datos para solicitar acceso al sistema VegGourmet.
            </p>

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

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <div class="mb-2">
                    <label class="auth-label" for="reg_nombre">Nombre *</label>
                    <input type="text"
                           id="reg_nombre"
                           name="nombre"
                           class="form-control form-control-auth"
                           placeholder="Nombre(s)"
                           value="{{ old('nombre') }}"
                           required>
                </div>

                <div class="mb-2">
                    <label class="auth-label" for="reg_apellidos">Apellidos *</label>
                    <input type="text"
                           id="reg_apellidos"
                           name="apellidos"
                           class="form-control form-control-auth"
                           placeholder="Apellidos"
                           value="{{ old('apellidos') }}"
                           required>
                </div>

                <div class="mb-2">
                    <label class="auth-label" for="reg_email">Correo electrónico *</label>
                    <input type="email"
                           id="reg_email"
                           name="email"
                           class="form-control form-control-auth"
                           placeholder="correo@ejemplo.com"
                           value="{{ old('email') }}"
                           required>
                </div>

                <div class="mb-2">
                    <label class="auth-label" for="reg_tipo">Rol solicitado *</label>
                    <select id="reg_tipo"
                            name="tipo"
                            class="form-select form-control-auth"
                            required>
                        <option value="">Selecciona un rol</option>
                        <option value="cliente"   {{ old('tipo') === 'cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="operador"  {{ old('tipo') === 'operador' ? 'selected' : '' }}>Operador</option>
                        <option value="admin"     {{ old('tipo') === 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    <small class="text-muted small">
                        Clientes se activan de inmediato. Operadores y administradores requieren aprobación.
                    </small>
                </div>

                <div class="mb-2">
                    <label class="auth-label" for="reg_password">Contraseña *</label>
                    <input type="password"
                           id="reg_password"
                           name="password"
                           class="form-control form-control-auth"
                           placeholder="Mín. 6 caracteres"
                           required>
                </div>

                <div class="mb-2">
                    <label class="auth-label" for="reg_password_confirmation">Confirmar contraseña *</label>
                    <input type="password"
                           id="reg_password_confirmation"
                           name="password_confirmation"
                           class="form-control form-control-auth"
                           required>
                    <small class="text-muted small">
                        Debe incluir al menos una mayúscula, un número y un símbolo.
                    </small>
                </div>

                <button type="submit" class="btn btn-success w-100 auth-cta-btn mt-2">
                    REGISTRARME
                </button>
            </form>
            <div class="text-center mt-3 small">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="fw-semibold" style="color:#198754;">Inicia sesión</a>
            </div>
        </div>
    </div>
</div>
@endsection
