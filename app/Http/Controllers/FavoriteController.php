<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Moto;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Moto $moto)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para guardar favoritos');
        }

        $fav = Favorite::where('user_id', auth()->id())
                        ->where('moto_id', $moto->id)
                        ->first();

        if ($fav) {
            $fav->delete();
            return back()->with('success', '❌ Removido de favoritos');
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'moto_id' => $moto->id
            ]);
            return back()->with('success', '❤️ Agregado a favoritos');
        }
    }

    public function index()
    {
        $motos = Favorite::where('user_id', auth()->id())->with('moto')->get();
        return view('motos.favoritos', compact('motos'));
    }
}
