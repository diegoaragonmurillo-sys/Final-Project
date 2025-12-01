@extends('admin.layout')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>✏ Editar Producto: <strong>{{ $moto->nombre }}</strong></h3>
        <a href="{{ route('admin.motos.index') }}" class="btn btn-secondary">⬅ Volver</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.motos.update', $moto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-3">
                    <label class="fw-bold">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $moto->nombre) }}" class="form-control" required>
                </div>

                {{-- Modelo --}}
                <div class="mb-3">
                    <label class="fw-bold">Modelo</label>
                    <input type="text" name="modelo" value="{{ old('modelo', $moto->modelo) }}" class="form-control">
                </div>

                {{-- Descripción --}}
                <div class="mb-3">
                    <label class="fw-bold">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $moto->descripcion) }}</textarea>
                </div>

                {{-- Categoría + Subcategoría --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold">Categoría</label>
                        <select name="categoria" class="form-select" id="categoriaSelect" required>
                            @foreach(['bicimotos','motos-electricas','trimotos','accesorios','repuestos'] as $cat)
                                <option value="{{ $cat }}" {{ old('categoria', $moto->categoria) == $cat ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('-', ' ', $cat)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6" id="subCategoriaBox" style="{{ $moto->categoria === 'repuestos' ? '' : 'display:none;' }}">
                        <label class="fw-bold">Subcategoría (solo repuestos)</label>
                        <select name="subcategoria" id="subcategoriaSelect" class="form-select" {{ $moto->categoria !== 'repuestos' ? 'disabled' : '' }}>
                            <option value="">-- Sin subcategoría --</option>
                            @foreach(['baterias','llantas','luces','cargadores'] as $sc)
                                <option value="{{ $sc }}" {{ old('subcategoria', $moto->subcategoria) == $sc ? 'selected' : '' }}>
                                    {{ ucfirst($sc) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Precio --}}
                <div class="mb-3">
                    <label class="fw-bold">Precio Unitario (S/.)</label>
                    <input type="number" step="0.01" name="precio_unit" value="{{ old('precio_unit', $moto->precio_unit) }}" class="form-control" required>
                </div>

                {{-- 🔥 Oferta --}}
                <h5 class="fw-bold mt-4">🔥 Oferta</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">¿Producto en oferta?</label>
                        <select name="oferta_activa" id="ofertaSelect" class="form-select">
                            <option value="0">No</option>
                            <option value="1" {{ old('oferta_activa', $moto->oferta_activa) ? 'selected' : '' }}>Sí</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Precio Oferta (S/.)</label>
                        <input type="number" step="0.01" name="precio_oferta" id="precioOferta" value="{{ old('precio_oferta', $moto->precio_oferta) }}" class="form-control" {{ $moto->oferta_activa ? '' : 'disabled' }}>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Descuento (%)</label>
                        <input type="number" name="descuento" id="descuento" value="{{ old('descuento', $moto->descuento) }}" min="1" max="99" class="form-control" {{ $moto->oferta_activa ? '' : 'disabled' }}>
                    </div>
                </div>
                <small class="text-muted">Define precio final o porcentaje — el sistema calculará automáticamente el restante.</small>


                {{-- Stock + Sede --}}
                <div class="row mb-3 mt-3">
                    <div class="col-md-4">
                        <label class="fw-bold">Stock disponible</label>
                        <input type="number" name="stock" value="{{ old('stock', $moto->stock) }}" class="form-control" min="0">
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold">Stock en llegada</label>
                        <input type="number" name="stock_llegada" value="{{ old('stock_llegada', $moto->stock_llegada) }}" class="form-control" min="0">
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold">Sede</label>
                        <select name="sede_id" class="form-select">
                            <option value="">-- Sin sede --</option>
                            @foreach($sedes as $sede)
                                <option value="{{ $sede->id }}" {{ $moto->sede_id == $sede->id ? 'selected' : '' }}>
                                    {{ $sede->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Imagen --}}
                <div class="mb-3">
                    <label class="fw-bold">Cambiar imagen</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*" onchange="previewImage(event)">

                    <div class="mt-3 row text-center">
                        <div class="col-md-6">
                            <small class="text-muted">Imagen actual</small>
                            <img src="{{ asset('storage/' . $moto->imagen) }}" width="140" class="border rounded shadow-sm mt-2">
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Nueva imagen</small>
                            <img id="preview" width="140" class="border rounded shadow-sm d-none mt-2">
                        </div>
                    </div>
                </div>

                {{-- Checkbox opciones --}}
                <h5 class="fw-bold mt-3">Opciones</h5>
                @foreach([
                    'recojo_tienda' => 'Recojo en tienda',
                    'entrega_domicilio' => 'Entrega a domicilio',
                    'pago_contra_entrega' => 'Pago contra entrega'
                ] as $campo => $label)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="{{ $campo }}" {{ $moto->$campo ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $label }}</label>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-success w-100 py-2 mt-4">
                    💾 Guardar cambios
                </button>

            </form>
        </div>
    </div>
</div>


{{-- Scripts --}}
<script>
function previewImage(event) {
    const preview = document.getElementById('preview');

    if (event.target.files.length > 0) {
        const file = event.target.files[0];
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    } else {
        preview.classList.add('d-none');
        preview.src = "";
    }
}

// Oferta dinámica
const ofertaSelect = document.getElementById("ofertaSelect");
const precioOferta = document.getElementById("precioOferta");
const descuentoInput = document.getElementById("descuento");

function toggleOferta() {
    const active = ofertaSelect.value == "1";
    precioOferta.disabled = !active;
    descuentoInput.disabled = !active;

    if (!active) {
        precioOferta.value = "";
        descuentoInput.value = "";
    }
}

toggleOferta();
ofertaSelect.addEventListener("change", toggleOferta);
</script>

@endsection
