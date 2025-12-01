@extends('layout')

@section('content')
<div class="container py-4">

    <h3>⚙ Variantes del Modelo: {{ $moto->nombre }}</h3>

    <a href="#" class="btn btn-success mb-3">+ Nueva Variante</a>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Color</th>
                <th>Autonomía</th>
                <th>Velocidad</th>
                <th>Precio adicional</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @forelse($variantes as $var)
            <tr>
                <td>{{ $var->color }}</td>
                <td>{{ $var->autonomia }} km</td>
                <td>{{ $var->velocidad }} km/h</td>
                <td>S/. {{ number_format($var->extra,2) }}</td>
                <td>
                    <button class="btn btn-warning btn-sm">Editar</button>
                    <button class="btn btn-danger btn-sm">Eliminar</button>
                </td>
            </tr>
            @empty
            <tr class="text-center">
                <td colspan="5">No hay variantes registradas aún.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
