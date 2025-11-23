<?php

namespace App\Http\Controllers;

use App\Models\Moto;
use App\Http\Requests\MotoRequest;

class MotoController extends Controller
{
    public function index()
    {
        $motos = Moto::paginate(6);
        return view('motos.index', compact('motos'));
    }

    public function show(Moto $moto)
    {
        return view('motos.show', compact('moto'));
    }

    public function create()
    {
        return view('motos.form');
    }

    public function store(MotoRequest $request)
    {
        Moto::create($request->validated());
        return redirect()->route('motos.index')->with('success', 'Moto registrada con éxito');
    }

    public function edit(Moto $moto)
    {
        return view('motos.form', compact('moto'));
    }

    public function update(MotoRequest $request, Moto $moto)
    {
        $moto->update($request->validated());
        return redirect()->route('motos.index')->with('success', 'Moto actualizada');
    }

    public function destroy(Moto $moto)
    {
        $moto->delete();
        return redirect()->route('motos.index')->with('success', 'Moto eliminada');
    }
}
