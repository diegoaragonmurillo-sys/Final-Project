<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Moto;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotoController extends Controller
{
    /** ---------------------------------------
    | 🔧 PANEL ADMINISTRADOR
    ----------------------------------------*/

    public function index()
    {
        $motos = Moto::with('sede')->latest()->paginate(10);
        return view('admin.motos.index', compact('motos'));
    }

    public function create()
    {
        $sedes = Sede::all();
        return view('admin.motos.create', compact('sedes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'categoria'     => 'required|string|max:255',
            'precio_unit'   => 'required|numeric|min:0',
            'imagen'        => 'nullable|image|max:5000'
        ]);

        /** 🧮 LÓGICA DE OFERTA */
        $precioUnit = $request->precio_unit;
        $ofertaActiva = $request->oferta_activa == 1;

        $precioOferta = $request->precio_oferta;
        $descuento = $request->descuento;

        if ($ofertaActiva) {

            if ($precioOferta && !$descuento) {
                $descuento = round((1 - ($precioOferta / $precioUnit)) * 100);
            }

            if ($descuento && !$precioOferta) {
                $precioOferta = round($precioUnit - ($precioUnit * ($descuento / 100)), 2);
            }

        } else {
            $precioOferta = null;
            $descuento = null;
        }

        /** 📁 Imagen */
        $imagenPath = $request->hasFile('imagen')
            ? $request->file('imagen')->store('productos', 'public')
            : 'productos/default.png';

        Moto::create([
            'nombre'                => $request->nombre,
            'modelo'                => $request->modelo ?? 'N/A',
            'descripcion'           => $request->descripcion ?? '',
            'categoria'             => $request->categoria,
            'subcategoria'          => $request->subcategoria,
            'precio_unit'           => $precioUnit,
            'precio_oferta'         => $precioOferta,
            'descuento'             => $descuento,
            'oferta_activa'         => $ofertaActiva,
            'stock'                 => $request->stock ?? 0,
            'stock_llegada'         => $request->stock_llegada ?? 0,
            'sede_id'               => $request->sede_id,
            'imagen'                => $imagenPath,
            'recojo_tienda'         => $request->has('recojo_tienda'),
            'entrega_domicilio'     => $request->has('entrega_domicilio'),
            'pago_contra_entrega'   => $request->has('pago_contra_entrega'),
        ]);

        return redirect()->route('admin.motos.index')->with('success', '✔ Producto registrado correctamente');
    }

    public function edit(Moto $moto)
    {
        $sedes = Sede::all();
        return view('admin.motos.edit', compact('moto', 'sedes'));
    }

    public function update(Request $request, Moto $moto)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'precio_unit' => 'required|numeric|min:0',
            'imagen'      => 'nullable|image|max:5000'
        ]);

        /** 🧮 LÓGICA OFERTA */
        $precioUnit = $request->precio_unit;
        $ofertaActiva = $request->oferta_activa == 1;

        $precioOferta = $request->precio_oferta;
        $descuento = $request->descuento;

        if ($ofertaActiva) {
            if ($precioOferta && !$descuento) {
                $descuento = round((1 - ($precioOferta / $precioUnit)) * 100);
            }

            if ($descuento && !$precioOferta) {
                $precioOferta = round($precioUnit - ($precioUnit * ($descuento / 100)), 2);
            }
        } else {
            $precioOferta = null;
            $descuento = null;
        }

        /** 📁 Manejo de imagen */
        if ($request->hasFile('imagen')) {
            if ($moto->imagen !== 'productos/default.png' && Storage::disk('public')->exists($moto->imagen)) {
                Storage::disk('public')->delete($moto->imagen);
            }

            $imagenPath = $request->file('imagen')->store('productos', 'public');
        } else {
            $imagenPath = $moto->imagen;
        }

        $moto->update([
            'nombre'                => $request->nombre,
            'modelo'                => $request->modelo,
            'descripcion'           => $request->descripcion,
            'categoria'             => $request->categoria,
            'subcategoria'          => $request->subcategoria,
            'precio_unit'           => $precioUnit,
            'precio_oferta'         => $precioOferta,
            'descuento'             => $descuento,
            'oferta_activa'         => $ofertaActiva,
            'stock'                 => $request->stock,
            'stock_llegada'         => $request->stock_llegada,
            'sede_id'               => $request->sede_id,
            'imagen'                => $imagenPath,
            'recojo_tienda'         => $request->has('recojo_tienda'),
            'entrega_domicilio'     => $request->has('entrega_domicilio'),
            'pago_contra_entrega'   => $request->has('pago_contra_entrega'),
        ]);

        return redirect()->route('admin.motos.index')->with('success', '✔ Producto actualizado correctamente');
    }

    public function destroy(Moto $moto)
    {
        if ($moto->imagen !== 'productos/default.png' && Storage::disk('public')->exists($moto->imagen)) {
            Storage::disk('public')->delete($moto->imagen);
        }

        $moto->delete();
        return back()->with('success', '🗑 Producto eliminado correctamente');
    }


    /** ---------------------------------------
    | 🛍 CATÁLOGO PÚBLICO
    ----------------------------------------*/
    public function catalog(Request $request, $categoria = null)
    {
        $query = Moto::query();

        if ($categoria) {
            $query->where('categoria', $categoria);
        }

        if ($request->filled('min')) {
            $query->where('precio_unit', '>=', $request->min);
        }

        if ($request->filled('max')) {
            $query->where('precio_unit', '<=', $request->max);
        }

        if ($request->order === "precio_asc") {
            $query->orderBy('precio_unit', 'asc');
        } elseif ($request->order === "precio_desc") {
            $query->orderBy('precio_unit', 'desc');
        } else {
            $query->latest();
        }

        $motos = $query->paginate(12)->appends($request->query());

        $view = $categoria ? "motos.categorias.$categoria" : "motos.index";

        // Si la vista no existe, cargar la vista general
        if (!view()->exists($view)) {
            $view = "motos.index";
        }

        return view($view, compact('motos', 'categoria'));
    }

    /** 🛒 DETALLE DEL PRODUCTO */
    public function show(Moto $moto)
    {
        $moto->load(['variantes', 'reviews']);
        return view('motos.detalle', compact('moto'));
    }

    /** ⭐ GUARDAR REVIEW */
    public function review(Request $request, Moto $moto)
    {
        $request->validate([
            'rating'     => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:500',
        ]);

        $moto->reviews()->create([
            'user_id'    => auth()->id(),
            'rating'     => $request->rating,
            'comentario' => $request->comentario,
        ]);

        return back()->with('success', '⭐ Gracias por tu opinión!');
    }
}
