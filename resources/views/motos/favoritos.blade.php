@extends('layout')

@section('content')
<h2>❤️ Mis Favoritos</h2>

@if(count($motos) === 0)
    <p>No tienes productos guardados.</p>
@else
<div class="row">
    @foreach($motos as $moto)
        <div class="col-md-4">
            <div class="card mb-3">
                <img src="{{ asset('uploads/motos/'.$moto->imagen) }}" class="card-img-top" height="200">
                <div class="card-body">
                    <h5 class="card-title">{{ $moto->nombre }}</h5>
                    <a href="{{ route('motos.show', $moto->id) }}" class="btn btn-primary w-100">Ver</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif
@endsection
