@extends('layout')

@section('content')
<div class="container py-4">
    <h3>⚙ Configuración del Modelo: {{ $moto->nombre }}</h3>

    <form action="{{ route('motos.settings.update', $moto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Stock Disponible</label>
                <input type="number" class="form-control" name="stock_disponible" value="{{ $moto->stock_disponible }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Stock en Llegada</label>
                <input type="number" class="form-control" name="stock_llegada" value="{{ $moto->stock_llegada }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Sede</label>
                <select name="sede_id" class="form-select">
                    @foreach($sedes as $sede)
                    <option value="{{ $sede->id }}" {{ $moto->sede_id == $sede->id ? 'selected' : '' }}>
                        {{ $sede->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <h5 class="mt-3">Opciones</h5>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="recojo_tienda" {{ $moto->recojo_tienda ? 'checked' : '' }}>
            <label class="form-check-label">Recojo en tienda</label>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="entrega_domicilio" {{ $moto->entrega_domicilio ? 'checked' : '' }}>
            <label class="form-check-label">Entrega a domicilio</label>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="pago_contra_entrega" {{ $moto->pago_contra_entrega ? 'checked' : '' }}>
            <label class="form-check-label">Pago contra entrega</label>
        </div>

        <button class="btn btn-primary mt-4">Guardar Cambios</button>
    </form>
</div>
@endsection
