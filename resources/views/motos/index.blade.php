@extends('layout')

@section('content')

<style>
    /* Imagen del catálogo */
    .catalog-img {
        width: 100%;
        height: 260px;
        object-fit: contain; /* 👈 mantiene proporción y no recorta */
        background: #fff;
        padding: 10px; 
        transition: .3s;
        border-radius: 10px 10px 0 0;
    }

    /* Efecto hover */
    .catalog-img:hover {
        transform: scale(1.05);
        filter: drop-shadow(0px 4px 8px rgba(0,0,0,.15));
    }

    /* Tarjeta */
    .moto-card {
        border-radius: 12px;
        overflow: hidden;
        transition: .25s;
    }

    .moto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
</style>



<h2 class="mb-4 text-center fw-bold">🔥 Catálogo de Motocicletas</h2>

<div class="row g-4">

@foreach ($motos as $moto)
    <div class="col-md-4">

        <div class="card moto-card shadow-sm border-0">

            {{-- Imagen uniformada --}}
            <img 
                src="{{ asset('uploads/motos/'.$moto->imagen) }}" 
                class="catalog-img"
                alt="{{ $moto->nombre }}"
            >

            <div class="card-body text-center">

                <h5 class="fw-bold">{{ $moto->nombre }} <br><span class="text-muted">({{ $moto->modelo }})</span></h5>

                <p class="text-success fw-semibold mb-2">
                    💰 S/ {{ number_format($moto->precio_unit,2) }}
                </p>

                {{-- Botón ver detalles --}}
                <a href="{{ route('motos.show', $moto->id) }}" 
                   class="btn btn-primary w-100">
                    🚀 Ver detalles
                </a>
            </div>
        </div>

    </div>
@endforeach

</div>

{{-- Paginación centrada --}}
<div class="mt-4 d-flex justify-content-center">
    {{ $motos->links() }}
</div>

@endsection
