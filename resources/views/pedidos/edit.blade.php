@extends('layouts.panel')

@section('title', 'Editar pedido')

@section('content')
<h1 class="h3 mb-3">Editar pedido</h1>

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
        <form action="{{ route('pedidos.update', $pedido) }}" method="POST">
            @method('PUT')
            @include('pedidos._form', ['pedido' => $pedido])
        </form>
    </div>
</div>
@endsection
