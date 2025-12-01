<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Moto;
use App\Models\User;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalMotos'     => Moto::count(),
            'totalPedidos'   => Order::count(),
            'totalUsuarios'  => User::count(),
            'stockLlegada'   => Moto::sum('stock'), // 👈 usamos stock normal
        ]);
    }
}
