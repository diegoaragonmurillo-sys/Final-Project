@extends('layout')

@section('content')
<h2>Panel Administrador ⚙️</h2>

<p class="lead">Bienvenido, {{ auth()->user()->name }}</p>

<a href="{{ route('admin') }}" class="btn btn-dark">Resumen</a>
<a href="{{ route('admin.motos.index') }}" class="btn btn-primary">Gestionar Motos</a>
@endsection
