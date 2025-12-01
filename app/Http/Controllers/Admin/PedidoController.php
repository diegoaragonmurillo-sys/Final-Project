<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::latest()->paginate(10);
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        $pedido->load('items.moto', 'usuario');
        return view('admin.pedidos.show', compact('pedido'));
    }
}
