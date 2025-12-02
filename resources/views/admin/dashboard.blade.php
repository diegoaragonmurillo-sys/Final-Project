@extends('admin.layout')

@section('content')

<style>
    .stat-card {
        padding: 22px;
        border-radius: 14px;
        color: white;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: .3s;
    }

    .stat-card:hover {
        transform: scale(1.03);
    }

    .stat-icon {
        font-size: 2.5rem;
        opacity: .9;
    }

    .table td { vertical-align: middle; }
</style>

<div class="container">

    <h2 class="fw-bold mb-4">📊 Panel Administrador</h2>

    {{-- ===== RESUMEN ESTADÍSTICAS ===== --}}
    <div class="row g-4">

        <div class="col-md-3">
            <div class="stat-card" style="background: #4e73df;">
                <i class="bi bi-bicycle stat-icon"></i>
                <div>
                    <h4 class="fw-bold mb-0">{{ $totalMotos }}</h4>
                    <p class="mb-0">Motos Registradas</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card" style="background: #1cc88a;">
                <i class="bi bi-cart-check stat-icon"></i>
                <div>
                    <h4 class="fw-bold mb-0">{{ $totalPedidos }}</h4>
                    <p class="mb-0">Pedidos Realizados</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card" style="background: #36b9cc;">
                <i class="bi bi-people stat-icon"></i>
                <div>
                    <h4 class="fw-bold mb-0">{{ $totalUsuarios }}</h4>
                    <p class="mb-0">Usuarios Registrados</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card" style="background: #f6c23e;">
                <i class="bi bi-box-seam stat-icon"></i>
                <div>
                    <h4 class="fw-bold mb-0">{{ $stockLlegada }}</h4>
                    <p class="mb-0">Stock Total</p>
                </div>
            </div>
        </div>

    </div>


    {{-- ===== GRÁFICO DE VENTAS ===== --}}
    <div class="card shadow-sm mt-5">
        <div class="card-body">
            <h5 class="fw-bold">📈 Ventas de los últimos 6 meses</h5>
            <canvas id="chartVentas" height="90"></canvas>
        </div>
    </div>


    {{-- ===== TABLA DE ÚLTIMOS PEDIDOS ===== --}}
    <div class="card shadow-sm mt-5">
        <div class="card-body">
            <h5 class="fw-bold">🧾 Últimos pedidos</h5>

            <table class="table table-hover mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimosPedidos as $pedido)
                        <tr>
                            <td>#{{ $pedido->id }}</td>
                            <td>{{ $pedido->usuario->name }}</td>
                            <td>S/ {{ number_format($pedido->total,2) }}</td>
                            <td>
                                <span class="badge 
                                    {{ $pedido->estado == 'entregado' ? 'bg-success' : 
                                       ($pedido->estado == 'cancelado' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </td>
                            <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Sin pedidos recientes</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    {{-- ===== TOP PRODUCTOS MÁS VENDIDOS ===== --}}
    <div class="card shadow-sm mt-5 mb-5">
        <div class="card-body">
            <h5 class="fw-bold">🔥 Productos más vendidos</h5>

            @if($topVendidos->count())
                <ul class="list-group mt-3">
                    @foreach($topVendidos as $prod)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $prod->nombre }}</span>
                            <strong>{{ $prod->total_vendido }} ventas</strong>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mt-2">Aún no hay suficientes ventas</p>
            @endif

        </div>
    </div>
</div>


{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('chartVentas').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($meses),
        datasets: [{
            label: 'Ventas (S/.)',
            data: @json($ventasMes),
            borderColor: '#1cc88a',
            backgroundColor: 'rgba(28,200,138,0.15)',
            borderWidth: 3,
            tension: 0.4
        }]
    }
});
</script>

@endsection
