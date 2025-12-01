@extends('layout')

@section('content')

<div class="container py-4">

    <h3>🏢 Sedes</h3>

    <form method="POST" action="{{ route('admin.sedes.store') }}" class="mb-4">
        @csrf

        <div class="row g-2">
            <div class="col-md-4"><input class="form-control" name="nombre" placeholder="Nombre"></div>
            <div class="col-md-4"><input class="form-control" name="direccion" placeholder="Dirección"></div>
            <div class="col-md-2"><input class="form-control" name="telefono" placeholder="Teléfono"></div>
            <div class="col-md-2"><button class="btn btn-primary w-100">Agregar</button></div>
        </div>
    </form>

    <table class="table table-striped">
        <thead><tr><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th></th></tr></thead>
        <tbody>
            @foreach($sedes as $s)
            <tr>
                <td>{{ $s->nombre }}</td>
                <td>{{ $s->direccion }}</td>
                <td>{{ $s->telefono }}</td>
                <td><button class="btn btn-danger btn-sm">Eliminar</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
