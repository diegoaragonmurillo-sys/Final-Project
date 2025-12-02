<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('usuario')->latest()->paginate(10);

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        $pedido->load('detalles.moto', 'usuario');

        return view('admin.pedidos.show', compact('pedido'));
    }

    /** 🟢 Cambiar estado del pedido */
    public function actualizarEstado(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,enviado,entregado'
        ]);

        // Si ya está entregado, bloquear edición (OPCIONAL)
        if ($pedido->estado === 'entregado') {
            return back()->with('error', '⚠ Este pedido ya fue marcado como entregado.');
        }

        $pedido->estado = $request->estado;
        $pedido->save();

        return back()->with('success', '✔ Estado actualizado correctamente.');
    }
    public function destroy(Pedido $pedido)
{
    // Elimina pedido y sus detalles porque está con cascade en la BD
    $pedido->delete();

    return redirect()->route('admin.pedidos.index')
        ->with('success', '🗑 Pedido eliminado correctamente.');
}
}
