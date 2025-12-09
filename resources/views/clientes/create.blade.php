@extends('layouts.panel')

@section('title', 'Nuevo cliente')

@section('content')
    <h1 class="mb-3">Nuevo cliente</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clientes.store') }}" method="POST">
        @include('clientes.form')

        <button type="submit" class="btn btn-success">
            Guardar
        </button>
    </form>
@endsection
