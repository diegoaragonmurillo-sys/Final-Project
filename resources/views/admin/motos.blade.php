@extends('layout')

@section('content')
<h2>Administrar Motocicletas</h2>

<a href="{{ route('motos.create') }}" class="btn btn-success mb-2">+ Nueva Moto</a>

<table class="table">
    <tr><th>Modelo</th><th>Precio</th><th>Acciones</th></tr>
    @foreach($motos as $moto)
        <tr>
            <td>{{ $moto->nombre }} - {{ $moto->modelo }}</td>
            <td>S/ {{ number_format($moto->precio_unit,2) }}</td>
            <td>
                <a class="btn btn-warning btn-sm" href="{{ route('motos.edit',$moto->id) }}">Editar</a>
            </td>
        </tr>
    @endforeach
</table>
@endsection
