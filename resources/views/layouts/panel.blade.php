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

    <style>
        :root {
            --vg-dark: #064e3b;      /* verde oscuro */
            --vg-darker: #022c22;   /* verde muy oscuro */
            --vg-light: #ecfdf5;    /* fondo muy claro */
            --vg-accent: #0f766e;   /* verde turquesa */
            --vg-accent-soft: #d1fae5;
            --vg-danger: #ef4444;
            --vg-warning: #f59e0b;
        }

        body {
            background-color: var(--vg-light);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .vg-wrapper {
            min-height: 100vh;
        }

        /* --------- SIDEBAR --------- */
        .vg-sidebar {
            width: 265px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--vg-dark), var(--vg-darker));
            color: #fff;
        }

        .vg-brand {
            font-weight: 700;
            letter-spacing: .08em;
            font-size: .9rem;
            text-transform: uppercase;
        }

        .vg-user-box {
            border-radius: 1rem;
            background: rgba(15, 118, 110, 0.35);
        }

        .vg-nav-title {
            font-size: .75rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #a7f3d0;
            margin-top: 1.4rem;
            margin-bottom: .3rem;
        }

        .vg-nav-link {
            color: #e5e7eb;
            font-size: .92rem;
            border-radius: 999px;
            padding: .55rem .9rem;
            display: flex;
            align-items: center;
            gap: .55rem;
            text-decoration: none;
        }

        .vg-nav-link .bi {
            font-size: 1rem;
        }

        .vg-nav-link:hover {
            background-color: rgba(16, 185, 129, 0.18);
            color: #ffffff;
        }

        .vg-nav-link.active {
            background: #0b1120;
            color: #ffffff;
        }

        .vg-nav-link.active .bi {
            color: #a7f3d0;
        }

        .vg-logout-btn {
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            color: #e5e7eb;
            width: 100%;
        }

        .vg-logout-btn:hover {
            background: #f87171;
            border-color: #fecaca;
            color: #ffffff;
        }

        /* --------- MAIN --------- */
        .vg-main {
            flex: 1;
            padding: 24px 32px;
        }

        .vg-main-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .vg-main-title {
            font-weight: 600;
            font-size: 1.7rem;
            color: #022c22;
        }

        .vg-main-subtitle {
            font-size: .9rem;
            color: #6b7280;
        }

        .vg-card-stat {
            border-radius: 1.25rem;
            border: none;
            padding: 1.1rem 1.4rem;
            color: #ffffff;
        }

        .vg-card-stat h6 {
            text-transform: uppercase;
            letter-spacing: .06em;
            font-size: .72rem;
            margin-bottom: .4rem;
        }

        .vg-card-stat .vg-stat-value {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .vg-card-stat.vg-stat-products { background: #0b1120; }
        .vg-card-stat.vg-stat-clients  { background: #f59e0b; }
        .vg-card-stat.vg-stat-orders   { background: #ea580c; }
        .vg-card-stat.vg-stat-low      { background: #dc2626; }

        .table thead {
            background-color: #e5f9f0;
        }

        .table thead th {
            border: none;
            font-size: .82rem;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #065f46;
        }

        .table td {
            vertical-align: middle;
            font-size: .9rem;
        }

        .badge-soft {
            background-color: #dcfce7;
            color: #166534;
        }
    </style>
</head>
<body>

<div class="d-flex vg-wrapper">

    {{-- SIDEBAR --}}
    <aside class="vg-sidebar d-flex flex-column p-3">
        @php
            $user = auth()->user();
        @endphp

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <div class="vg-brand">VEGGOURMET</div>
                <small class="text-gray-300">
                    @if($user && $user->tipo === 'admin') Admin
                    @elseif($user && $user->tipo === 'operador') Operador
                    @elseif($user && $user->tipo === 'cliente') Cliente
                    @endif
                </small>
            </div>
        </div>

        {{-- Caja de usuario --}}
        <div class="vg-user-box p-3 mb-3">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center"
                     style="width:36px;height:36px;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <div class="fw-semibold small">{{ $user->name ?? 'Usuario' }}</div>
                    <div class="text-white-50 small">
                        @if($user && $user->tipo === 'admin') Administrador
                        @elseif($user && $user->tipo === 'operador') Operador
                        @else Cliente
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Navegación según rol --}}
        @if($user && in_array($user->tipo, ['admin','operador']))
            {{-- PANEL --}}
            <div class="vg-nav-title">Panel</div>
            <a href="{{ route($user->tipo.'.dashboard') }}"
               class="vg-nav-link {{ request()->routeIs($user->tipo.'.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            {{-- VENTAS --}}
            <div class="vg-nav-title">Ventas</div>
            <a href="{{ route('pedidos.index') }}"
               class="vg-nav-link {{ request()->routeIs('pedidos.*') ? 'active' : '' }}">
                <i class="bi bi-bag-check"></i>
                <span>Pedidos</span>
            </a>

            {{-- INVENTARIO --}}
            <div class="vg-nav-title">Inventario</div>
            <a href="{{ route('productos.index') }}"
               class="vg-nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span>Productos</span>
            </a>
            <a href="{{ route('categorias.index') }}"
               class="vg-nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>
                <span>Categorías</span>
            </a>

            {{-- CLIENTES --}}
            <div class="vg-nav-title">Clientes</div>
            <a href="{{ route('clientes.index') }}"
               class="vg-nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Clientes</span>
            </a>

            {{-- ADMINISTRACIÓN (solo admin) --}}
            @if($user->tipo === 'admin')
                <div class="vg-nav-title">Administración</div>
                <a href="{{ route('empleados.index') }}"
                   class="vg-nav-link {{ request()->routeIs('empleados.*') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i>
                    <span>Empleados</span>
                </a>
                <a href="{{ route('admin.solicitudes') }}"
                   class="vg-nav-link {{ request()->routeIs('admin.solicitudes*') ? 'active' : '' }}">
                    <i class="bi bi-inboxes"></i>
                    <span>Solicitudes</span>
                </a>
            @endif

        @elseif($user && $user->tipo === 'cliente')
            {{-- MENU CLIENTE --}}
            <div class="vg-nav-title">Cliente</div>
            <a href="{{ route('cliente.productos') }}"
               class="vg-nav-link {{ request()->routeIs('cliente.productos') ? 'active' : '' }}">
                <i class="bi bi-basket"></i>
                <span>Productos</span>
            </a>
            <a href="{{ route('cart.index') }}"
               class="vg-nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                <i class="bi bi-cart3"></i>
                <span>Mi carrito</span>
            </a>
        @endif

        {{-- Botón salir --}}
        <div class="mt-auto pt-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn vg-logout-btn">
                    <i class="bi bi-box-arrow-right me-1"></i> Salir
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="vg-main">
        {{-- Cabecera genérica del main (puedes sobrescribirla en tus vistas) --}}
        @hasSection('page_header')
            @yield('page_header')
        @else
            <div class="vg-main-header">
                <div>
                    <div class="vg-main-title">@yield('page_title', 'Dashboard general')</div>
                    <div class="vg-main-subtitle">
                        @yield('page_subtitle', 'Resumen del estado actual del restaurante.')
                    </div>
                </div>
            </div>
        @endif

        {{-- Contenido real de cada vista --}}
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
