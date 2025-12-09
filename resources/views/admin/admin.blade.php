@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
<style>
    .dash-wrapper {
        display: flex;
    }
    .dash-sidebar {
        width: 230px;
        background-color: #061133;
        color: #fff;
        border-radius: 12px;
        padding: 1.5rem 1rem;
        margin-right: 1.5rem;
        min-height: 70vh;
    }
    .dash-sidebar .user-name {
        font-weight: 700;
        font-size: 1rem;
    }
    .dash-sidebar .user-role {
        font-size: .85rem;
        opacity: .8;
    }
    .dash-menu-title {
        font-size: .85rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        opacity: .6;
        margin-top: 1.25rem;
        margin-bottom: .25rem;
    }
    .dash-menu a {
        display: flex;
        align-items: center;
        gap: .5rem;
        color: #fff;
        text-decoration: none;
        padding: .45rem .7rem;
        border-radius: 999px;
        font-size: .9rem;
        margin-bottom: .2rem;
    }
    .dash-menu a:hover,
    .dash-menu a.active {
        background-color: #0d1f5a;
    }
    .dash-main {
        flex: 1;
    }
    .dash-cards .card {
        border-radius: 16px;
        color: #fff;
        border: none;
    }
    .dash-card-1 { background-color: #001f4d; }
    .dash-card-2 { background-color: #f0aa0d; }
    .dash-card-3 { background-color: #f25d27; }
    .dash-card-4 { background-color: #c93a4a; }

    .dash-card-title {
        font-size: .85rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        opacity: .85;
    }
    .dash-card-value {
        font-size: 1.4rem;
        font-weight: 700;
    }
</style>

<div class="dash-wrapper">
    {{-- Sidebar estilo panel --}}
    <aside class="dash-sidebar d-none d-md-block">
        <div class="mb-3">
            <div class="user-name">{{ $user->name }}</div>
            <div class="user-role">
                {{ ucfirst($user->tipo) }}
            </div>
        </div>

        <div class="dash-menu">
            <div class="dash-menu-title">Navegación</div>
            <a href="{{ route('admin.dashboard') }}" class="active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('productos.index') }}">
                <i class="bi bi-box-seam"></i> Productos
            </a>
            <a href="{{ route('clientes.index') }}">
                <i class="bi bi-people"></i> Clientes
            </a>
            <a href="{{ route('pedidos.index') }}">
                <i class="bi bi-receipt"></i> Pedidos
            </a>

            @if($user->tipo === 'admin')
                <div class="dash-menu-title">Administración</div>
                <a href="{{ route('empleados.index') }}">
                    <i class="bi bi-person-badge"></i> Empleados
                </a>
                <a href="{{ route('admin.solicitudes') }}">
                    <i class="bi bi-person-plus"></i> Solicitudes
                </a>
            @endif
        </div>
    </aside>

    {{-- Contenido principal --}}
    <div class="dash-main">
        <h1 class="h4 mb-3">Dashboard</h1>

        {{-- Tarjetas superiores --}}
        <div class="row g-3 dash-cards mb-4">
            <div class="col-md-3">
                <div class="card dash-card-1 p-3">
                    <div class="dash-card-title">Ingresos hoy</div>
                    <div class="dash-card-value">${{ number_format($ingresosHoy, 2) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dash-card-2 p-3">
                    <div class="dash-card-title">Productos con stock bajo</div>
                    <div class="dash-card-value">{{ $productosStockBajo }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dash-card-3 p-3">
                    <div class="dash-card-title">Total productos</div>
                    <div class="dash-card-value">{{ $totalProductos }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dash-card-4 p-3">
                    <div class="dash-card-title">Pedidos registrados</div>
                    <div class="dash-card-value">{{ $totalPedidos }}</div>
                </div>
            </div>
        </div>

        {{-- Tabla de "próximos" (aquí usamos los de menor stock) --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title mb-3">Productos con menor stock</h5>

                @if($proximos->isEmpty())
                    <p class="text-muted mb-0">No hay productos registrados.</p>
                @else
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                    <th>Stock mínimo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proximos as $inv)
                                    <tr>
                                        <td>{{ $inv->producto->nombre ?? 'Sin nombre' }}</td>
                                        <td>{{ $inv->stock }}</td>
                                        <td>{{ $inv->stock_minimo }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
