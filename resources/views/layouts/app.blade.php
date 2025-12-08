<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'VegGourmet')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        {{-- Branding --}}
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            VEGGOURMET
            @auth
                @if(auth()->user()->tipo === 'admin')
                    &middot; ADMIN
                @elseif(auth()->user()->tipo === 'operador')
                    &middot; OPERADOR
                @elseif(auth()->user()->tipo === 'cliente')
                    &middot; CLIENTE
                @endif
            @endauth
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar" aria-controls="mainNavbar"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">

                {{-- Invitado (no ha iniciado sesión) --}}
                @guest
                    {{-- NO mostrar estos links si ya estamos en login o registro --}}
                    @if (!request()->routeIs('login') && !request()->routeIs('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endif
                @endguest

                {{-- Usuario autenticado --}}
                @auth
                    {{-- ADMIN y OPERADOR: menú de administración --}}
                    @if(in_array(auth()->user()->tipo, ['admin', 'operador']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('productos.index') }}">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pedidos.index') }}">Pedidos</a>
                        </li>
                    @endif

                    {{-- Solo ADMIN: empleados y solicitudes --}}
                    @if(auth()->user()->tipo === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('empleados.index') }}">Empleados</a>
                        </li>
                        <li class="nav-item">
                            {{-- ESTE ES EL BOTÓN "Nueva solicitud" --}}
                            <a class="nav-link" href="{{ route('admin.solicitudes') }}">Nueva solicitud</a>
                        </li>
                    @endif

                    {{-- CLIENTE: solo catálogo --}}
                    @if(auth()->user()->tipo === 'cliente')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cliente.productos') }}">Productos</a>
                        </li>
                    @endif

                    {{-- Botón Salir --}}
                    <li class="nav-item ms-2">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link p-0">
                                Salir
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    @yield('content')
</main>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
