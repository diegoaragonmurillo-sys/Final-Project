@extends('admin.layout')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Cupones registrados</h3>
        <a href="{{ route('admin.cupones.create') }}" class="btn btn-success">
            + Nuevo cupón
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Valor aplicado</th>
                        <th>Usos</th>
                        <th>Expira</th>
                        <th>Estado</th>
                        <th class="text-end" style="width: 220px;">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($cupones as $c)
                    <tr>
                        {{-- Código --}}
                        <td class="fw-bold">{{ strtoupper($c->codigo) }}</td>

                        {{-- Tipo --}}
                        <td class="text-capitalize">
                            {{ $c->tipo === 'porcentaje' ? 'Porcentaje' : 'Monto fijo' }}
                        </td>

                        {{-- Valor mostrado correctamente --}}
                        <td>
                            @if($c->tipo === 'porcentaje')
                                <span class="badge bg-success">{{ $c->valor }}%</span>
                            @else
                                <span class="badge bg-info">S/ {{ number_format($c->valor, 2) }}</span>
                            @endif
                        </td>

                        {{-- Uso del cupón --}}
                        <td>
                            @if($c->uso_maximo)
                                {{ $c->usos_realizados }} / {{ $c->uso_maximo }}
                            @else
                                <span class="text-muted">Ilimitado</span>
                            @endif
                        </td>

                        {{-- Fecha expiración --}}
                        <td>
                            {{ $c->fecha_expira ? $c->fecha_expira : '—' }}
                        </td>

                        {{-- Estado --}}
                        <td>
                            @if($c->activo)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </td>

                        {{-- Botones --}}
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                
                                <a href="{{ route('admin.cupones.edit', $c->id) }}"
                                    class="btn btn-light border-warning text-warning btn-sm px-3">
                                    Editar
                                </a>

                                <form action="{{ route('admin.cupones.destroy', $c->id) }}" 
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar este cupón?');">
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
                        <td colspan="7" class="text-center text-muted py-4">
                            No hay cupones registrados aún.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    {{-- Paginación --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $cupones->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection
