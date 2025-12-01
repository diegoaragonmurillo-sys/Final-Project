<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function redes()
    {
        $settings = Setting::firstOrCreate([]);
        return view('admin.configuracion.redes', compact('settings'));
    }

    public function updateRedes(Request $request)
    {
        Setting::updateOrCreate([], $request->all());
        return back()->with('success', 'Redes actualizadas.');
    }

    public function pagos()
    {
        $settings = Setting::firstOrCreate([]);
        return view('admin.configuracion.pagos', compact('settings'));
    }

    public function updatePagos(Request $request)
    {
        Setting::updateOrCreate([], $request->all());
        return back()->with('success', 'Métodos de pago actualizados.');
    }
}
