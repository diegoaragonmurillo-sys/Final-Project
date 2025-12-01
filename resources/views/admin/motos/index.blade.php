@extends('admin.layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Productos registradas</h3>
    <a href="{{ route('admin.motos.create') }}" class="btn btn-success">
        + Nueva moto
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">

        <table class="table table-striped align-middle mb-0">
            <thead class="table-dark text-center">
                <tr>
                    <th style="width:50px;">ID</th>
                    <th style="width:90px;">Imagen</th>
                    <th class="text-start">Producto</th>
                    <th style="width:140px;">Categoría</th>
                    <th style="width:90px;">Stock</th>
                    <th style="width:130px;">Precio</th>
                    <th style="width:100px;">Oferta</th>
                    <th style="width:150px;">Sede</th>
                    <th style="width:220px;">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($motos as $moto)
                <tr>

                    {{-- ID --}}
                    <td class="text-center fw-bold">{{ $moto->id }}</td>

                    {{-- Imagen --}}
                    <td class="text-center">
                        <div style="width:65px; height:65px; overflow:hidden; border-radius:10px; background:#f3f3f3;">
                            <img src="{{ asset('storage/' . $moto->imagen) }}"
                                onerror="this.src='/storage/productos/default.png'"
                                alt="{{ $moto->nombre }}"
                                style="width:100%; height:100%; object-fit:cover;">
                        </div>
                    </td>

                    {{-- Nombre --}}
                    <td class="fw-semibold text-start">
                        {{ $moto->nombre }}<br>
                        <small class="text-muted">{{ $moto->modelo }}</small>
                    </td>

                    {{-- Categoría --}}
                    <td class="text-center text-capitalize">
                        {{ str_replace('-', ' ', $moto->categoria) }}
                        @if($moto->subcategoria)
                            <br><small class="text-muted">({{ ucfirst($moto->subcategoria) }})</small>
                        @endif
                    </td>

                    {{-- Stock --}}
                    <td class="text-center">
                        <span class="badge 
                            @if($moto->stock < 5) bg-danger 
                            @elseif($moto->stock <= 10) bg-warning
                            @else bg-success 
                            @endif px-3 py-2">
                            {{ $moto->stock }}
                        </span>
                    </td>

                    {{-- Precio --}}
                    <td class="text-center fw-semibold">
                        S/. {{ number_format($moto->precio_unit,2) }}
                    </td>

                    {{-- Oferta --}}
                    <td class="text-center">
                        @if($moto->oferta_activa && $moto->precio_oferta)
                            <span class="badge bg-danger px-3 py-2">-{{ $moto->descuento }}%</span><br>
                            <small class="text-success fw-bold">
                                S/. {{ number_format($moto->precio_oferta,2) }}
                            </small>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    {{-- Sede --}}
                    <td class="text-center">
                        {{ $moto->sede->nombre ?? 'Sin asignar' }}
                    </td>

                    {{-- Acciones --}}
                    <td class="text-center">

                        <div class="d-flex justify-content-center gap-2">

                            <a href="{{ route('admin.motos.show', $moto->id) }}" 
                               class="btn btn-light border-primary text-primary btn-sm px-3">
                                Ver
                            </a>

                            <a href="{{ route('admin.motos.edit', $moto->id) }}" 
                               class="btn btn-light border-warning text-warning btn-sm px-3">
                                Editar
                            </a>

                            <form action="{{ route('admin.motos.destroy', $moto->id) }}" 
                                  method="POST"
                                  onsubmit="return confirm('¿Eliminar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-light border-danger text-danger btn-sm px-3">
                                    Eliminar
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        No hay productos registrados aún.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

<div class="mt-3 d-flex justify-content-center">
    {{ $motos->links('pagination::bootstrap-5') }}

</div>

@endsection
