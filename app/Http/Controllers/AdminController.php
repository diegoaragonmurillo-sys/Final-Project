<?php

namespace App\Http\Controllers;

use App\Models\Moto;
use App\Models\Order;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'motos' => Moto::count(),
            'ordenes' => Order::count(),
        ]);
    }
}
