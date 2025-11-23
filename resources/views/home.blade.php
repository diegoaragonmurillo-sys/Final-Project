@extends('layout')

@section('content')

<div class="text-center">
    <h1 class="fw-bold">Bienvenido a MotoVolt Perú ⚡</h1>
    <p class="lead">Motocicletas eléctricas premium al mejor precio.</p>
    <a href="{{ route('motos.index') }}" class="btn btn-success btn-lg">Ver catálogo</a>
</div>

@endsection
