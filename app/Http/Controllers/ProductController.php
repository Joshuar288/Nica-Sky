<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\Image;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'priceFilter' => ['nullable', 'numeric', 'min:0'],
            'departmentFilter' => ['nullable', 'string', 'max:255'],
            'cityFilter' => ['nullable', 'integer', 'exists:cities,id'],
            'categoryFilter' => ['nullable', 'integer', 'exists:categories,id'],
        ]);

        $minPriceDb = (float) (Product::min('price') ?? 0);
        $maxPriceDb = (float) (Product::max('price') ?? 0);
        $partPrice = ($maxPriceDb - $minPriceDb) / 4;
        $priceOptions = collect(range(1, 4))
            ->map(fn (int $part) => $minPriceDb + ($partPrice * $part))
            ->unique()
            ->values();

        $selectedPrice = isset($validated['priceFilter'])
            ? min((float) $validated['priceFilter'], $maxPriceDb)
            : $maxPriceDb;
        $selectedDepartment = $validated['departmentFilter'] ?? null;
        $selectedCity = $validated['cityFilter'] ?? null;
        $selectedCategory = $validated['categoryFilter'] ?? null;
        $search = trim($validated['q'] ?? '');
        $searchTerms = collect(preg_split('/\s+/u', Str::lower($search), -1, PREG_SPLIT_NO_EMPTY))
            ->prepend(Str::lower($search))
            ->flatMap(function (string $term) {
                $variants = [$term, Str::ascii($term)];

                foreach ([$term, Str::ascii($term)] as $variant) {
                    if (mb_strlen($variant) > 3 && str_ends_with($variant, 's')) {
                        $variants[] = mb_substr($variant, 0, -1);
                    }

                    if (mb_strlen($variant) > 4 && str_ends_with($variant, 'es')) {
                        $variants[] = mb_substr($variant, 0, -2);
                    }
                }

                return $variants;
            })
            ->filter(fn (string $term) => mb_strlen($term) >= 3)
            ->unique()
            ->values();

        $products = Product::with(['images', 'user.city'])
            ->when($searchTerms->isNotEmpty(), function ($query) use ($searchTerms) {
                $query->where(function ($searchQuery) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $searchQuery
                            ->orWhere('title', 'like', "%{$term}%")
                            ->orWhere('description', 'like', "%{$term}%")
                            ->orWhereHas('category', fn ($categoryQuery) => $categoryQuery->where('name', 'like', "%{$term}%"))
                            ->orWhereHas('user', function ($userQuery) use ($term) {
                                $userQuery->where(function ($nameQuery) use ($term) {
                                    $nameQuery
                                        ->where('name', 'like', "%{$term}%")
                                        ->orWhere('name_bussines', 'like', "%{$term}%");
                                });
                            });
                    }
                });
            })
            ->when($maxPriceDb > 0, fn ($query) => $query->where('price', '<=', $selectedPrice))
            ->when($selectedDepartment, function ($query, $department) {
                $query->whereHas('user.city', fn ($cityQuery) => $cityQuery->where('name_departament', $department));
            })
            ->when($selectedCity, function ($query, $cityId) {
                $query->whereHas('user', fn ($userQuery) => $userQuery->where('city_id', $cityId));
            })
            ->when($selectedCategory, fn ($query, $categoryId) => $query->where('category_id', $categoryId))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::whereHas('products')
            ->orderBy('type_category')
            ->orderBy('name')
            ->get();
        $cities = City::whereHas('users.products')
            ->orderBy('name_departament')
            ->orderBy('name_city')
            ->get();
        $departments = $cities->pluck('name_departament')->unique()->values();

        return view('product.index', compact(
            'products',
            'categories',
            'cities',
            'departments',
            'minPriceDb',
            'maxPriceDb',
            'selectedPrice',
            'selectedDepartment',
            'selectedCity',
            'selectedCategory',
            'search',
            'priceOptions'
        ));
    }

    public function create()
    {
        $categories = Category::orderBy('type_category')->orderBy('name')->get();
        $user = auth()->user();
        $recommendedCount = $user->recommendedProductsCount();
        $recommendedLimit = $user->recommendedProductsLimit();

        return view('product.create', compact('categories', 'user', 'recommendedCount', 'recommendedLimit'));
    }

    public function show(Product $product)
    {
        DB::transaction(function () use ($product) {
            $isFirstView = DB::table('product_views')->insertOrIgnore([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($isFirstView) {
                $product->increment('views_count');
            }
        });

        $product->load(['images', 'category', 'user.city']);

        $relatedProducts = Product::with(['images', 'user'])
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->getKey())
            ->latest()
            ->limit(4)
            ->get();

        return view('product.show', compact('product', 'relatedProducts'));
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
            'is_recommended' => 'nullable|boolean',
        ]);

        $product = DB::transaction(function () use ($request, $validated) {
            $user = User::query()->lockForUpdate()->findOrFail(auth()->id());
            $isRecommended = $user->plan === 'pro_3'
                || ($user->canSelectRecommendations() && $request->boolean('is_recommended'));

            if ($isRecommended && ! $user->canRecommendAnotherProduct()) {
                throw ValidationException::withMessages([
                    'is_recommended' => "Tu plan ya alcanzó el límite de {$user->recommendedProductsLimit()} productos recomendados.",
                ]);
            }

            return Product::create([
                'user_id' => $user->id,
                'category_id' => $validated['category_id'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'unit' => $validated['unit'],
                'stock' => $validated['stock'] ?? null,
                'state' => $validated['state'],
                'is_recommended' => $isRecommended,
            ]);
        });

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
