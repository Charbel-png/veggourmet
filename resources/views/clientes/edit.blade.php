@extends('layouts.app')

@section('title', 'Editar cliente')

@section('content')
    <h1 class="mb-3">Editar cliente</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
        @method('PUT')
        @include('clientes.form')

        <button type="submit" class="btn btn-primary">
            Actualizar
        </button>
    </form>
@endsection
