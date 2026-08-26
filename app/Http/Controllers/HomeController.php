<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $popularProducts = Product::with(['images', 'user'])
            ->orderByDesc('views_count')
            ->latest()
            ->limit(50)
            ->get()
            ->shuffle()
            ->take(8);

        $recommendedProducts = Product::with(['images', 'user'])
            ->where('is_recommended', true)
            ->latest()
            ->limit(8)
            ->get();

        return view('home', compact('popularProducts', 'recommendedProducts'));
    }

    public function popular(): View
    {
        $popularProducts = Product::with(['images', 'user'])
            ->orderByDesc('views_count')
            ->latest()
            ->limit(50)
            ->get()
            ->shuffle()
            ->take(30);

        return view('product.popular', compact('popularProducts'));
    }

    public function recommended(): View
    {
        $recommendedProducts = Product::with(['images', 'user'])
            ->where('is_recommended', true)
            ->latest()
            ->paginate(15);

        return view('product.recommended', compact('recommendedProducts'));
    }
}
