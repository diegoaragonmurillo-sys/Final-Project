@extends('layout')

@section('content')
<h2>{{ isset($moto) ? 'Editar Moto' : 'Crear Moto' }}</h2>

<form method="POST" action="{{ isset($moto) ? route('motos.update',$moto->id) : route('motos.store') }}">
    @csrf
    @if(isset($moto)) @method('PUT') @endif

    <input class="form-control mb-2" name="nombre" placeholder="Nombre" value="{{ $moto->nombre ?? '' }}">
    <input class="form-control mb-2" name="modelo" placeholder="Modelo" value="{{ $moto->modelo ?? '' }}">
    <textarea class="form-control mb-2" name="descripcion">{{ $moto->descripcion ?? '' }}</textarea>
    <input class="form-control mb-2" name="precio_unit" placeholder="Precio unitario" value="{{ $moto->precio_unit ?? '' }}">
    <input class="form-control mb-2" name="precio_mayor" placeholder="Precio mayorista" value="{{ $moto->precio_mayor ?? '' }}">
    <button class="btn btn-primary w-100">Guardar</button>
</form>
@endsection
