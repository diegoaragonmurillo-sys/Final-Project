<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Moto;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 📌 Resumen general
        $totalMotos     = Moto::count();
        $totalPedidos   = Pedido::count();
        $totalUsuarios  = User::count();
        $stockLlegada   = Moto::sum('stock');

        // 📌 Últimos 5 pedidos
        $ultimosPedidos = Pedido::with('usuario')->latest()->take(5)->get();

        // 📌 Top 5 productos más vendidos
        $topVendidos = Moto::select('motos.id', 'motos.nombre')
            ->join('pedido_detalles', 'pedido_detalles.moto_id', '=', 'motos.id')
            ->selectRaw('SUM(pedido_detalles.cantidad) as total_vendido')
            ->groupBy('motos.id', 'motos.nombre')
            ->orderByDesc('total_vendido')
            ->take(5)
            ->get();

        // 📈 Ventas de los últimos 6 meses
        $ventas = Pedido::select(
                DB::raw("DATE_FORMAT(created_at, '%M') as mes_nombre"),
                DB::raw("SUM(total) as total_mes")
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mes_nombre')
            ->orderByRaw("MIN(created_at)")
            ->get();

        $meses = $ventas->pluck('mes_nombre');
        $ventasMes = $ventas->pluck('total_mes');

        return view('admin.dashboard', compact(
            'totalMotos',
            'totalPedidos',
            'totalUsuarios',
            'stockLlegada',
            'ultimosPedidos',
            'topVendidos',
            'meses',
            'ventasMes'
        ));
    }
}
