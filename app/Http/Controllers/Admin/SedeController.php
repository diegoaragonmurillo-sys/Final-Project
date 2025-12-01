<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sede;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    public function index()
    {
        $sedes = Sede::all();
        return view('admin.configuracion.sedes', compact('sedes'));
    }

    public function store(Request $request)
    {
        Sede::create($request->all());
        return back()->with('success','Sede creada.');
    }

    public function destroy(Sede $sede)
    {
        $sede->delete();
        return back()->with('success', 'Sede eliminada.');
    }
}
