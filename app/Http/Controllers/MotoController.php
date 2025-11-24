<?php

namespace App\Http\Controllers;

use App\Models\Moto;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\MotoRequest;

class MotoController extends Controller
{
    /** Mostrar catálogo **/
    public function index()
    {
        $motos = Moto::paginate(6);
        return view('motos.index', compact('motos'));
    }

    /** Mostrar detalles + reviews **/
    public function show(Moto $moto)
    {
        // Cargar reviews con usuario
        $reviews = $moto->reviews()->latest()->get();

        return view('motos.show', compact('moto', 'reviews'));
    }

    /** Form admin */
    public function create()
    {
        return view('motos.form');
    }

    /** Guardar moto admin */
    public function store(MotoRequest $request)
    {
        Moto::create($request->validated());
        return redirect()->route('motos.index')->with('success', 'Moto registrada con éxito');
    }

    /** Editar */
    public function edit(Moto $moto)
    {
        return view('motos.form', compact('moto'));
    }

    /** Actualizar */
    public function update(MotoRequest $request, Moto $moto)
    {
        $moto->update($request->validated());
        return redirect()->route('motos.index')->with('success', 'Moto actualizada');
    }

    /** Eliminar */
    public function destroy(Moto $moto)
    {
        $moto->delete();
        return redirect()->route('motos.index')->with('success', 'Moto eliminada');
    }

    /** ⭐ Nuevo: Guardar review */
    public function review(Request $request, Moto $moto)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comentario' => 'required|min:5'
        ]);

        $moto->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comentario' => $request->comentario
        ]);

        return back()->with('success', 'Gracias por tu reseña ⭐');
    }
    public function favorito(Moto $moto)
    {
    // Obtener favoritos actuales
    $favoritos = session()->get('favoritos', []);

    // Si ya existe, no lo duplicamos
    if (!in_array($moto->id, $favoritos)) {
        $favoritos[] = $moto->id;
        session()->put('favoritos', $favoritos);
    }

    return redirect()->back()->with('success', '❤️ Agregado a favoritos');
    }

}
