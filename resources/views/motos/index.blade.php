@extends('layout')

@section('content')
<h2 class="mb-4">Catálogo de Motocicletas</h2>

<div class="row">
@foreach ($motos as $moto)
    <div class="col-md-4 mb-3">
        <div class="card">
            <img src="{{ asset('uploads/motos/'.$moto->imagen) }}" class="card-img-top" height="200">
            <div class="card-body">
                <h5 class="card-title">{{ $moto->nombre }} ({{ $moto->modelo }})</h5>
                <p class="card-text">Precio: <strong>S/ {{ number_format($moto->precio_unit,2) }}</strong></p>
                <a href="{{ route('motos.show', $moto->id) }}" class="btn btn-primary w-100">Ver detalles</a>
            </div>
        </div>
    </div>
@endforeach
</div>

{{ $motos->links() }}
@endsection
