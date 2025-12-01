@extends('admin.layout')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>📄 Detalles de Moto: {{ $moto->nombre }}</h3>
        <a href="{{ route('admin.motos.index') }}" class="btn btn-secondary">◀ Volver</a>
    </div>

    <div class="card shadow-sm p-4">
        <div class="row">

            {{-- Imagen --}}
            <div class="col-md-5 text-center">
                <img src="{{ asset('uploads/motos/'.$moto->variantes->first()->imagen) }}" 
                     class="img-fluid rounded shadow-sm">
            </div>

            {{-- Datos Básicos --}}
            <div class="col-md-7">
                <h4 class="fw-bold">{{ $moto->nombre }} ({{ $moto->modelo }})</h4>

                <p><strong>Precio:</strong> S/ {{ number_format($moto->precio_unit,2) }}</p>
                <p><strong>Categoría:</strong> {{ $moto->categoria }}</p>
                <p><strong>Estado:</strong> 
                    @if($moto->stock > 0)
                        <span class="badge bg-success">Disponible</span>
                    @else
                        <span class="badge bg-danger">Agotado</span>
                    @endif
                </p>

                <hr>

                {{-- Variantes --}}
                <h5 class="fw-bold">🎨 Variantes</h5>
                @foreach($moto->variantes as $var)
                    <p>
                        <img src="{{ asset('uploads/motos/'.$var->imagen) }}" width="40" height="40" class="rounded shadow-sm">
                        {{ $var->color_nombre }} — Stock: {{ $var->stock }}
                    </p>
                @endforeach

                <hr>

                <a href="{{ route('admin.motos.edit', $moto) }}" class="btn btn-primary">
                    ✏ Editar Moto
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
