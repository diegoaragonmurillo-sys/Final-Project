<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }
}
