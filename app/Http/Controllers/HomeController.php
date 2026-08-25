<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularProducts = Product::with(['images', 'user'])
            ->orderByDesc('views_count')
            ->latest()
            ->limit(8)
            ->get();

        $recommendedProducts = Product::with(['images', 'user'])
            ->latest()
            ->limit(8)
            ->get();

        return view('home', compact('popularProducts', 'recommendedProducts'));
    }
}
