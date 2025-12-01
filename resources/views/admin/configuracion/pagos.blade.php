@extends('layout')

@section('content')
<div class="container py-4">
    <h3>💰 Métodos de Pago</h3>

    <form action="{{ route('admin.config.pagos.update') }}" method="POST">
        @csrf

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="contraentrega" {{ $settings->contraentrega ? 'checked' : '' }}>
            <label class="form-check-label">Pago contra entrega</label>
        </div>

        <div class="mb-3">
            <label>Yape / Plin (Número)</label>
            <input type="text" class="form-control" name="yape" value="{{ $settings->yape }}">
        </div>

        <div class="mb-3">
            <label>Cuenta bancaria</label>
            <input type="text" class="form-control" name="cuenta" value="{{ $settings->cuenta }}">
        </div>

        <button class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
