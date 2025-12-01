<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moto;
use App\Models\MotoVariante;
use App\Models\Cupon;

class CarritoController extends Controller
{
    /** 🛍 Mostrar carrito */
    public function index(Request $request)
    {
        $carrito = session()->get('carrito', []);

        // Si el usuario intenta aplicar un cupón
        if ($request->filled('cupon')) {

            $codigo = strtoupper(trim($request->cupon));

            // Buscar cupon
            $cupon = Cupon::where('codigo', $codigo)->first();

            if (!$cupon) {
                return back()->with('error', '❌ Cupón no encontrado.');
            }

            // Validar si está activo
            if (!$cupon->activo) {
                return back()->with('error', '⚠ Este cupón está desactivado.');
            }

            // Validar expiración (si tiene fecha)
            if ($cupon->fecha_expira && now()->gt($cupon->fecha_expira)) {
                return back()->with('error', '⚠ Este cupón está expirado.');
            }

            // Validar límite de usos
            if (!is_null($cupon->uso_maximo) && $cupon->uso_maximo < 1) {
                return back()->with('error', '🚫 Este cupón ya alcanzó su límite de uso.');
            }

            // Guardar cupón en sesión
            session()->put('cupon', $codigo);
            session()->put('cupon_data', $cupon);

            return back()->with('success', '🎉 Cupón aplicado correctamente.');
        }

        $cupon = session()->get('cupon');
        $cuponData = session()->get('cupon_data');

        return view('carrito.index', compact('carrito', 'cupon', 'cuponData'));
    }

    /** ➕ Agregar producto al carrito */
    public function agregar(Request $request)
    {
        $request->validate([
            'moto_id' => 'required|numeric',
            'cantidad' => 'required|numeric|min:1'
        ]);

        $moto = Moto::findOrFail($request->moto_id);
        $cantidad = $request->cantidad;

        $carrito = session()->get('carrito', []);

        /** Si tiene variante */
        if ($request->filled('variante_id')) {

            $variante = MotoVariante::findOrFail($request->variante_id);
            $key = $moto->id . '-' . $variante->id;

            $producto = [
                'id' => $key,
                'moto' => $moto->nombre . ' (' . $moto->modelo . ')',
                'color' => $variante->color_nombre,
                'imagen' => $variante->imagen,
                'precio' => $moto->oferta_activa ? $moto->precio_oferta : $moto->precio_unit,
                'cantidad' => $cantidad,
            ];

        } else {

            $key = $moto->id;

            $producto = [
                'id' => $moto->id,
                'moto' => $moto->nombre . ' (' . $moto->modelo . ')',
                'color' => null,
                'imagen' => $moto->imagen,
                'precio' => $moto->oferta_activa ? $moto->precio_oferta : $moto->precio_unit,
                'cantidad' => $cantidad,
            ];
        }

        // Si ya existe, sumar cantidad
        if (isset($carrito[$key])) {
            $carrito[$key]['cantidad'] += $cantidad;
        } else {
            $carrito[$key] = $producto;
        }

        session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')->with('success', '🛒 Producto agregado al carrito.');
    }

    /** ❌ Eliminar producto */
    public function eliminar($key)
    {
        $carrito = session()->get('carrito', []);
        unset($carrito[$key]);
        session()->put('carrito', $carrito);

        return back()->with('success', '🗑 Producto eliminado.');
    }

    /** 🔄 Actualizar cantidad */
    public function actualizar($key, $accion)
    {
        $carrito = session()->get('carrito', []);

        if (!isset($carrito[$key])) {
            return back()->with('error', 'Producto no encontrado.');
        }

        if ($accion === 'sumar') {
            $carrito[$key]['cantidad']++;
        } elseif ($accion === 'restar' && $carrito[$key]['cantidad'] > 1) {
            $carrito[$key]['cantidad']--;
        }

        session()->put('carrito', $carrito);

        return back()->with('success', 'Cantidad actualizada.');
    }

    /** 🧹 Vaciar carrito */
    public function vaciar()
    {
        session()->forget(['carrito', 'cupon', 'cupon_data']);
        return back()->with('success', '🧹 Carrito vaciado.');
    }
}
