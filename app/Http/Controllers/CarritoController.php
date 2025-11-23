<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moto;
use App\Models\MotoVariante;

class CarritoController extends Controller
{
    /**
     * Mostrar el carrito
     */
    public function index()
    {
        $carrito = session()->get('carrito', []);

        return view('carrito.index', compact('carrito'));
    }

    /**
     * Agregar producto al carrito con variante seleccionada
     */
    public function agregar(Request $request)
    {
        // Validar que vengan los datos
        if (!$request->moto_id || !$request->variante_id) {
            return redirect()->back()->with('error', 'Seleccione un color antes de continuar.');
        }

        $moto = Moto::findOrFail($request->moto_id);
        $variante = MotoVariante::findOrFail($request->variante_id);

        $carrito = session()->get('carrito', []);

        // Crear llave única moto+variante para evitar duplicados incorrectos
        $key = $moto->id . '-' . $variante->id;

        // Si ya existe, aumentar cantidad
        if (isset($carrito[$key])) {
            $carrito[$key]['cantidad']++;
        } else {
            // Nuevo item en carrito
            $carrito[$key] = [
                'id'       => $key,
                'moto'     => $moto->nombre . ' (' . $moto->modelo . ')',
                'color'    => $variante->color_nombre,
                'imagen'   => $variante->imagen,
                'precio'   => $moto->precio_unit,
                'cantidad' => 1,
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito correctamente.');
    }

    /**
     * Eliminar un item del carrito
     */
    public function eliminar($key)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$key])) {
            unset($carrito[$key]);
            session()->put('carrito', $carrito);
        }

        return redirect()->back()->with('success', 'Producto eliminado del carrito.');
    }
}
