@extends('layouts.panel')

@section('title', 'Nuevo pedido')

@section('content')
<h1 class="h3 mb-3">Nuevo pedido</h1>

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
        <form action="{{ route('pedidos.store') }}" method="POST">
            @include('pedidos._form', ['pedido' => new \App\Models\Pedido()])
        </form>
    </div>
</div>
@endsection
