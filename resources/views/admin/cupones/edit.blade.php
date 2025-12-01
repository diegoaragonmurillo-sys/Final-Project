@extends('admin.layout')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between mb-4">
        <h3 class="fw-bold">Editar Cupón</h3>
        <a href="{{ route('admin.cupones.index') }}" class="btn btn-secondary">Volver</a>
    </div>

    {{-- MENSAJES DE ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>⚠ Errores detectados:</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.cupones.update', $cupon->id) }}">
                @csrf
                @method('PUT')

                {{-- Código --}}
                <div class="mb-3">
                    <label class="fw-bold">Código del cupón</label>
                    <input type="text"
                           name="codigo"
                           value="{{ old('codigo', $cupon->codigo) }}"
                           class="form-control"
                           required>
                </div>

                {{-- Tipo --}}
                <div class="mb-3">
                    <label class="fw-bold">Tipo de descuento</label>
                    <select name="tipo" class="form-select" required>
                        <option value="porcentaje" {{ $cupon->tipo == 'porcentaje' ? 'selected' : '' }}>Porcentaje (%)</option>
                        <option value="fijo" {{ $cupon->tipo == 'fijo' ? 'selected' : '' }}>Monto fijo (S/.)</option>
                    </select>
                </div>

                {{-- Valor --}}
                <div class="mb-3">
                    <label class="fw-bold">Valor del descuento</label>
                    <input type="number"
                           step="0.01"
                           name="valor"
                           value="{{ old('valor', $cupon->valor) }}"
                           class="form-control"
                           required>
                </div>

                {{-- Fecha de expiración --}}
                <div class="mb-3">
                    <label class="fw-bold">Fecha de expiración (opcional)</label>
                    <input type="date"
                           name="fecha_expira"
                           value="{{ old('fecha_expira', $cupon->fecha_expira) }}"
                           class="form-control">
                </div>

                {{-- Sin límite de uso --}}
                <div class="form-check form-switch mb-3">
                    <input type="checkbox"
                           id="ilimitadoCheck"
                           name="sin_limite"
                           class="form-check-input"
                           {{ $cupon->uso_maximo === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="ilimitadoCheck">Cupón sin límite de usos</label>
                </div>

                {{-- Uso máximo --}}
                <div class="mb-3" id="usoMaximoBox">
                    <label class="fw-bold">Límite de usos</label>
                    <input type="number"
                           name="uso_maximo"
                           value="{{ old('uso_maximo', $cupon->uso_maximo ?? 1) }}"
                           class="form-control">
                </div>

                {{-- Estado --}}
                <div class="form-check mb-4">
                    <input type="checkbox"
                           name="activo"
                           class="form-check-input"
                           {{ $cupon->activo ? 'checked' : '' }}>
                    <label class="form-check-label">Cupón activo</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    Guardar Cambios
                </button>
            </form>

        </div>
    </div>

</div>

{{-- Script: ocultar/mostrar límite de uso --}}
<script>
    const ilimitado = document.getElementById("ilimitadoCheck");
    const usoBox = document.getElementById("usoMaximoBox");

    function toggleUso() {
        usoBox.style.display = ilimitado.checked ? "none" : "block";
    }

    toggleUso();
    ilimitado.addEventListener("change", toggleUso);
</script>

@endsection
