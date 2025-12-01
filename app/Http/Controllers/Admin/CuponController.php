<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cupon;
use Illuminate\Http\Request;

class CuponController extends Controller
{
    /** 📄 LISTAR CUPONES */
    public function index()
    {
        $cupones = Cupon::orderBy('id', 'desc')->paginate(8);

        return view('admin.cupones.index', compact('cupones'));
    }


    /** ➕ FORMULARIO NUEVO */
    public function create()
    {
        return view('admin.cupones.create');
    }


    /** 💾 GUARDAR CUPÓN */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo'       => 'required|string|max:50|unique:cupons,codigo',
            'tipo'         => 'required|in:porcentaje,fijo',
            'valor'        => 'required|numeric|min:1',
            'fecha_expira' => 'nullable|date',
            'uso_maximo'   => $request->has('sin_limite') ? 'nullable' : 'required|integer|min:1',
        ]);

        // Si es ilimitado: null, si no se usa el dato ingresado
        $validated['uso_maximo'] = $request->has('sin_limite') ? null : $request->uso_maximo;

        // Estado activo
        $validated['activo'] = $request->has('activo') ? 1 : 0;

        // Siempre inicia en 0
        $validated['usos_realizados'] = 0;

        Cupon::create($validated);

        return redirect()
            ->route('admin.cupones.index')
            ->with('success', '✔ Cupón creado correctamente.');
    }


    /** ✏ EDITAR */
    public function edit(Cupon $cupon)
    {
        return view('admin.cupones.edit', compact('cupon'));
    }


    /** 🔄 ACTUALIZAR */
    public function update(Request $request, Cupon $cupon)
    {
        $validated = $request->validate([
            'codigo'       => 'required|string|max:50|unique:cupons,codigo,' . $cupon->id,
            'tipo'         => 'required|in:porcentaje,fijo',
            'valor'        => 'required|numeric|min:1',
            'fecha_expira' => 'nullable|date',
            'uso_maximo'   => $request->has('sin_limite') ? 'nullable' : 'required|integer|min:1',
        ]);

        $validated['uso_maximo'] = $request->has('sin_limite') ? null : $request->uso_maximo;
        $validated['activo'] = $request->has('activo') ? 1 : 0;

        $cupon->update($validated);

        return redirect()
            ->route('admin.cupones.index')
            ->with('success', '✔ Cupón actualizado correctamente.');
    }


    /** 🗑 ELIMINAR */
    public function destroy(Cupon $cupon)
    {
        $cupon->delete();

        return back()->with('success', '🗑 Cupón eliminado correctamente.');
    }
}
    