@extends('layout')

@section('content')

<div class="container py-4">

    <h2 class="fw-bold mb-4">📦 Mis pedidos</h2>

    {{-- Si no hay pedidos --}}
    @if ($pedidos->isEmpty())
        <div class="alert alert-warning text-center py-4 shadow-sm">
            😅 Aún no tienes pedidos realizados.
            <br><br>
            <a href="{{ route('home') }}" class="btn btn-success px-4">🛒 Ir a comprar</a>
        </div>
    @else

        <div class="table-responsive">
            <table class="table table-hover shadow-sm align-middle">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr class="text-center">
                            <td class="fw-bold">#{{ $pedido->id }}</td>

                            {{-- Etiqueta con color dinámico --}}
                            <td>
                                @php
                                    $badge = match($pedido->estado) {
                                        'pendiente' => 'warning',
                                        'procesando' => 'info',
                                        'completado' => 'success',
                                        'cancelado' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp

                                <span class="badge bg-{{ $badge }} px-3 py-2">
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </td>

                            <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>

                            <td class="fw-bold text-success">
                                S/ {{ number_format($pedido->total, 2) }}
                            </td>

                            <td>
                                <a href="{{ route('orden.detalle', $pedido->id) }}" 
                                   class="btn btn-sm btn-primary px-3">
                                    👀 Ver detalles
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

</div>

@endsection
