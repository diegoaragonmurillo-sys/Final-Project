@extends('admin.layout')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between mb-4">
        <h3 class="fw-bold">Crear Cupón</h3>
        <a href="{{ route('admin.cupones.index') }}" class="btn btn-secondary">Volver</a>
    </div>

    {{-- MENSAJES --}}
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

            <form method="POST" action="{{ route('admin.cupones.store') }}">
                @csrf

                {{-- Código --}}
                <div class="mb-3">
                    <label class="fw-bold">Código del cupón</label>
                    <input type="text" name="codigo" value="{{ old('codigo') }}" class="form-control" placeholder="Ej: BLACKFRIDAY50" required>
                </div>

                {{-- Tipo --}}
                <div class="mb-3">
                    <label class="fw-bold">Tipo de descuento</label>
                    <select name="tipo" class="form-select" required>
                        <option value="porcentaje" {{ old('tipo')=='porcentaje' ? 'selected' : '' }}>Porcentaje (%)</option>
                        <option value="fijo" {{ old('tipo')=='fijo' ? 'selected' : '' }}>Monto fijo (S/.)</option>
                    </select>
                </div>

                {{-- Valor --}}
                <div class="mb-3">
                    <label class="fw-bold">Valor del descuento</label>
                    <input type="number" step="0.01" name="valor" value="{{ old('valor') }}" class="form-control" placeholder="Ej: 10 o 50" required>
                    <small class="text-muted">Ejemplo: 20 = 20%, ó 50 = S/50 si es monto fijo.</small>
                </div>

                {{-- Fecha de expiración --}}
                <div class="mb-3">
                    <label class="fw-bold">Fecha de expiración (opcional)</label>
                    <input type="date" name="fecha_expira" value="{{ old('fecha_expira') }}" class="form-control">
                </div>

                {{-- SIN LÍMITE DE USO --}}
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" id="ilimitadoCheck" name="sin_limite" class="form-check-input"
                           {{ old('sin_limite') ? 'checked' : '' }}>
                    <label class="form-check-label" for="ilimitadoCheck">Cupón sin límite de usos</label>
                </div>

                {{-- Uso máximo --}}
                <div class="mb-3" id="usoMaximoBox">
                    <label class="fw-bold">Límite de usos</label>
                    <input type="number" name="uso_maximo" value="{{ old('uso_maximo',1) }}" class="form-control" min="1">
                </div>

                {{-- Activo --}}
                <div class="form-check mb-4">
                    <input type="checkbox" name="activo" class="form-check-input" {{ old('activo',true) ? 'checked' : '' }}>
                    <label class="form-check-label">Cupón activo</label>
                </div>

                <button type="submit" class="btn btn-success w-100 py-2">
                    Guardar Cupón
                </button>
            </form>

        </div>
    </div>

</div>

{{-- Script: Ocultar / Mostrar límite de uso --}}
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
