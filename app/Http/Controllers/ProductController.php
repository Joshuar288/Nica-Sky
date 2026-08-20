<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Image;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Obtener el precio mínimo y máximo real de la base de datos
        $minPriceDb = (float) Product::min('price') ?? 0;
        $maxPriceDb = (float) Product::max('price') ?? 1000;
        $partPrice = ($maxPriceDb - $minPriceDb) / 4;

        // 2. Capturar el precio seleccionado (si no hay selección, usa el máximo)
        $selectedPrice = $request->input('priceFilter', $maxPriceDb);

        // 3. Filtrar los productos por el rango seleccionado
        $products = Product::where('price', '<=', $selectedPrice)
            ->latest()
            ->paginate(12)
            ->appends($request->query()); // Mantiene el filtro al cambiar de página

        $categories = Category::orderBy('type_category')->orderBy('name')->get();

        return view('product.index', compact('products', 'categories', 'minPriceDb', 'maxPriceDb', 'selectedPrice', 'partPrice'));
    }

    public function create()
    {
        // Ordena por type_category y luego por name
        $categories = Category::orderBy('type_category')->orderBy('name')->get();

        return view('product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price'       => 'required|numeric|min:0',
            'unit'        => 'required|string|max:50',
            'stock'       => 'nullable|integer|min:0',
            'state'       => 'required|string|in:Nuevo,Usado,Reacondicionado',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 1. Guardar el producto
        $product = Product::create([
            'user_id'     => auth()->id(),
            'category_id' => $validated['category_id'],
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'unit'        => $validated['unit'],
            'stock'       => $validated['stock'] ?? null,
            'state'       => $validated['state'],
        ]);

        // 2. Guardar la imagen asociada en la tabla images
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');

            Image::create([
                'product_id' => $product->id,
                'rute'       => $path,
                'is_first'   => true, // Marcada como primera/principal
            ]);
        }

        return redirect()->route('myprofile.show')->with('success', '¡Publicación creada exitosamente!');
    }
}
