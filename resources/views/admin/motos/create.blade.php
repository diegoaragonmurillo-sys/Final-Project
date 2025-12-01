@extends('admin.layout')

@section('content')

<div class="container py-4">

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>⚠ Ups! Hay errores:</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>➕ Registrar Moto / Producto</h3>
        <a href="{{ route('admin.motos.index') }}" class="btn btn-secondary">◀ Volver</a>
    </div>


    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.motos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf



                {{-- NOMBRE --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
                </div>

                {{-- MODELO --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Modelo</label>
                    <input type="text" name="modelo" value="{{ old('modelo') }}" class="form-control">
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
                </div>



                {{-- CATEGORÍA / SUBCATEGORÍA --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Categoría</label>
                        <select name="categoria" id="categoriaSelect" class="form-select" required>
                            <option value="">-- Seleccionar categoría --</option>
                            @foreach(['bicimotos','motos-electricas','trimotos','accesorios','repuestos'] as $cat)
                                <option value="{{ $cat }}" {{ old('categoria') == $cat ? 'selected' : '' }}>
                                    {{ ucfirst($cat) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6" id="subCategoriaBox" style="display: none;">
                        <label class="form-label fw-bold">Subcategoría (solo repuestos)</label>
                        <select name="subcategoria" id="subcategoriaSelect" class="form-select">
                            <option value="">-- Seleccionar --</option>
                            @foreach(['baterias','llantas','luces','cargadores'] as $sc)
                                <option value="{{ $sc }}" {{ old('subcategoria') == $sc ? 'selected' : '' }}>
                                    {{ ucfirst($sc) }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Disponible solo cuando la categoría sea repuestos.</small>
                    </div>
                </div>




                {{-- PRECIO BASE --}}
                <div class="mb-3">
                    <label class="fw-bold">Precio Unitario (S/.)</label>
                    <input type="number" step="0.01" name="precio_unit" value="{{ old('precio_unit') }}" class="form-control" required>
                </div>


                {{-- OFERTA --}}
                <h5 class="fw-bold mt-4">🔥 Oferta (Opcional)</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">¿Producto en oferta?</label>
                        <select name="oferta_activa" id="ofertaSelect" class="form-select">
                            <option value="0">No</option>
                            <option value="1" {{ old('oferta_activa') ? 'selected' : '' }}>Sí</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Precio Oferta (S/.)</label>
                        <input type="number" step="0.01" name="precio_oferta" id="precioOferta" value="{{ old('precio_oferta') }}" class="form-control" disabled>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Descuento (%)</label>
                        <input type="number" name="descuento" id="descuento" value="{{ old('descuento') }}" min="1" max="99" class="form-control" disabled>
                    </div>
                </div>
                <small class="text-muted">Define precio final o porcentaje — el sistema calculará automáticamente el restante.</small>


                {{-- STOCK --}}
                <div class="row mt-3">
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Stock disponible</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Stock en llegada (opcional)</label>
                        <input type="number" name="stock_llegada" value="{{ old('stock_llegada') }}" class="form-control" min="0">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Sede</label>
                        <select name="sede_id" class="form-select">
                            <option value="">-- Seleccionar sede --</option>
                            @foreach($sedes as $sede)
                                <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>




                {{-- IMAGEN --}}
                <div class="mb-3">
                    <label class="fw-bold">Imagen principal</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <img id="preview" src="/imagenes/productos/default.png" width="120" class="border rounded shadow-sm mt-2">
                </div>




                {{-- OPCIONES ENTREGA --}}
                <h5 class="fw-bold mt-3">🚚 Opciones de entrega</h5>

                @foreach(['recojo_tienda' => 'Recojo en tienda', 'entrega_domicilio' => 'Entrega a domicilio', 'pago_contra_entrega' => 'Pago contra entrega'] as $campo => $label)
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" name="{{ $campo }}" {{ old($campo) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $label }}</label>
                    </div>
                @endforeach



                <button type="submit" class="btn btn-success w-100 py-2 mt-4">
                    💾 Guardar Producto
                </button>

            </form>
        </div>
    </div>
</div>



{{-- SCRIPT --}}
<script>
function previewImage(event) {
    document.getElementById('preview').src = URL.createObjectURL(event.target.files[0]);
}

// Mostrar/Ocultar subcategoría
const categoriaSelect = document.getElementById("categoriaSelect");
const subCategoriaBox = document.getElementById("subCategoriaBox");
const subSelect = document.getElementById("subcategoriaSelect");

function toggleSubcategoria() {
    if (categoriaSelect.value === "repuestos") {
        subCategoriaBox.style.display = "block";
        subSelect.disabled = false;
    } else {
        subCategoriaBox.style.display = "none";
        subSelect.disabled = true;
        subSelect.value = "";
    }
}
toggleSubcategoria();
categoriaSelect.addEventListener("change", toggleSubcategoria);


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
