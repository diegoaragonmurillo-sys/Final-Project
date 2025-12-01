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

        /**
         * 🧩 Subcategorías SOLO para REPUESTOS
         */
        $subcategories = [
            'baterias', 'llantas', 'luces', 'cargadores',
            'controladores', 'frenos'
        ];

        /**
         * 👉 Si la URL coincide con subcategoría → la tratamos como "repuestos"
         */
        if (in_array($categoria, $subcategories)) {
            $request->merge(['subcategoria' => $categoria]); 
            $categoria = 'repuestos';
        }

        // 📍 FILTRO POR CATEGORÍA PRINCIPAL
        if ($categoria) {
            $query->where('categoria', $categoria);
        }

        // 🧩 FILTRO POR SUBCATEGORÍA REAL
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
        if ($request->filled('min')) {
            $query->where('precio_unit', '>=', $request->min);
        }
        if ($request->filled('max')) {
            $query->where('precio_unit', '<=', $request->max);
        }

        // ↕ Ordenamiento
        switch ($request->order) {
            case 'price_asc':
                $query->orderBy('precio_unit', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('precio_unit', 'desc');
                break;
            default:
                $query->latest();
        }

        // 📦 Resultados paginados
        $motos = $query->paginate(9)->withQueryString();

        /**
         * 🎨 Banners asignados por categoría
         */
        $bannerImages = [
            'bicimotos'         => 'ui/bicimotos.jpg',
            'motos-electricas'  => 'ui/motos-electricas.jpg',
            'trimotos'          => 'ui/trimotos.jpg',
            'accesorios'        => 'ui/accesorios.png', // ahora su propio banner
            'repuestos'         => 'ui/repuestos.jpg',
        ];

        $banner = $bannerImages[$categoria] ?? 'ui/catalogo-default.jpg';

        return view('motos.catalogo', compact('motos', 'categoria', 'banner'));
    }


    /**
     * 🛒 Detalle del producto
     */
    public function show(Moto $moto)
    {
        $reviews = $moto->reviews()->latest()->get();
        return view('motos.detalle', compact('moto', 'reviews'));
    }

    public function index(Request $request)
{
    return $this->catalog($request, 'motos-electricas');
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
