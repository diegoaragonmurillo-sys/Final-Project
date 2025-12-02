@extends('layout')

@section('content')

<style>
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: .85rem;
        font-weight: bold;
        text-transform: capitalize;
    }

    .status-pendiente { background:#ffc107; color:#000; }
    .status-procesando { background:#0dcaf0; color:#000; }
    .status-enviado { background:#0d6efd; color:white; }
    .status-entregado { background:#198754; color:white; }
    .status-cancelado { background:#dc3545; color:white; }
</style>

<div class="container py-4">
    <h2 class="fw-bold mb-4">
        📦 Historial de pedidos
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($pedidos->isEmpty())
        <div class="alert alert-warning text-center p-4">
            🛍️ Aún no realizaste pedidos.
            <br>
            <a href="{{ route('motos.index') }}" class="btn btn-success mt-3">
                Explorar catálogo
            </a>
        </div>
    @else

        <div class="table-responsive shadow-sm">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th width="150px">Acción</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pedidos as $pedido)
                    <tr>
                        <td class="fw-bold">#{{ $pedido->id }}</td>
                        <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>

                        <td class="text-success fw-bold">
                            S/ {{ number_format($pedido->total,2) }}
                        </td>

                        <td>
                            <span class="status-badge status-{{ strtolower($pedido->estado) }}">
                                {{ $pedido->estado }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('orden.detalle', $pedido->id) }}" 
                               class="btn btn-outline-primary btn-sm w-100 fw-semibold d-flex justify-content-center align-items-center gap-2">
                                <i class="bi bi-receipt"></i> Ver detalles
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
