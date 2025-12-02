<?php

namespace App\Http\Controllers;

use App\Models\Moto;
use Illuminate\Http\Request;

class MotoPublicController extends Controller
{
    /**
     * 🛍 Catálogo público con filtros por categoría y subcategoría
     */
    public function catalog(Request $request, $categoria = null)
    {
        $query = Moto::query();

        // 🧩 Subcategorías SOLO para REPUESTOS
        $subcategories = [
            'baterias', 'llantas', 'luces', 'cargadores',
            'controladores', 'frenos'
        ];

        // 👉 Si la URL coincide con subcategoría → tratamos como repuestos
        if (in_array($categoria, $subcategories)) {
            $request->merge(['subcategoria' => $categoria]); 
            $categoria = 'repuestos';
        }

        // 📍 FILTRO POR CATEGORÍA PRINCIPAL
        if ($categoria) {
            $query->where('categoria', $categoria);
        }

        // 🧩 FILTRO SUBCATEGORÍA
        if ($request->filled('subcategoria')) {
            $query->where('subcategoria', $request->subcategoria);
        }

        // 🔍 Filtro búsqueda
        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'LIKE', "%{$request->buscar}%")
                  ->orWhere('descripcion', 'LIKE', "%{$request->buscar}%")
                  ->orWhere('modelo', 'LIKE', "%{$request->buscar}%");
            });
        }

        // 💰 Filtros de precio
        if ($request->filled('min')) $query->where('precio_unit', '>=', $request->min);
        if ($request->filled('max')) $query->where('precio_unit', '<=', $request->max);

        // ↕ Ordenamiento
        match($request->order) {
            'price_asc' => $query->orderBy('precio_unit', 'asc'),
            'price_desc' => $query->orderBy('precio_unit', 'desc'),
            default => $query->latest()
        };

        // 📦 Resultados paginados
        $motos = $query->paginate(9)->withQueryString();

        /**
         * 🎨 Banners asignados por categoría
         */
        $bannerImages = [
            'catalogo'          => 'ui/bicimotos.jpg',   // Banner por defecto
            'bicimotos'         => 'ui/bicimotos.jpg',
            'motos-electricas'  => 'ui/motos-electricas.jpg',
            'trimotos'          => 'ui/trimotos.jpg',
            'accesorios'        => 'ui/accesorios.png',
            'repuestos'         => 'ui/repuestos.jpg',
        ];

        // 🧠 Normalizamos categoría
        $categoriaKey = strtolower(trim($categoria ?? 'catalogo'));

        // 🖼 Obtenemos banner
        $banner = $bannerImages[$categoriaKey] ?? $bannerImages['catalogo'];

        // 🛡 Validación extra (si el archivo no existe)
        if (!file_exists(public_path("imagenes/" . $banner))) {
            $banner = $bannerImages['catalogo'];
        }

        return view('motos.catalogo', compact('motos', 'categoria', 'banner'));
    }


    /**
     * 🛒 Vista detalle
     */
    public function show(Moto $moto)
    {
        $reviews = $moto->reviews()->latest()->get();
        return view('motos.detalle', compact('moto', 'reviews'));
    }

    /**
     * 📍 Entrada general sin categoría explícita
     */
    public function index(Request $request)
    {
        $categoria = $request->categoria ?? null;
        return $this->catalog($request, $categoria);
    }


    /**
     * ⭐ Crear reseña
     */
    public function review(Request $request, Moto $moto)
    {
        $request->validate([
            'rating' => 'required|min:1|max:5',
            'comentario' => 'required|min:5'
        ]);

        $moto->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comentario' => $request->comentario
        ]);

        return back()->with('success', '⭐ Gracias por tu reseña');
    }
}
