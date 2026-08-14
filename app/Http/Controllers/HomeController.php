<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Datos de ejemplo simulados según la interfaz
        $popularProducts = [
            ['title' => 'Adidas Superstar', 'price' => 120, 'image' => 'https://images.unsplash.com/photo-1518002171953-a080ee817e1f?auto=format&fit=crop&q=80&w=400', 'seller' => 'Laura Johnson', 'time' => 'Hace 1 día'],
            ['title' => 'Vans Old Skool', 'price' => 75, 'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&q=80&w=400', 'seller' => 'Alex Chen', 'time' => 'Hace 3 horas'],
            ['title' => 'Converse Chuck T.', 'price' => 55, 'image' => 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?auto=format&fit=crop&q=80&w=400', 'seller' => 'María Sánchez', 'time' => 'Hace 5 horas'],
            ['title' => 'Puma Suede Classic', 'price' => 79, 'image' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?auto=format&fit=crop&q=80&w=400', 'seller' => 'Chris Thompson', 'time' => 'Hace 2 días'],
        ];

        $recommendedProducts = [
            ['title' => 'Nike Air Max', 'price' => 140, 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=400', 'seller' => 'David Miller', 'time' => 'Hace 6 horas'],
            ['title' => 'New Balance 574', 'price' => 95, 'image' => 'https://images.unsplash.com/photo-1539185441755-769473a23570?auto=format&fit=crop&q=80&w=400', 'seller' => 'Sarah Jenkins', 'time' => 'Hace 12 horas'],
            ['title' => 'Asics Gel-Lyte', 'price' => 110, 'image' => 'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&fit=crop&q=80&w=400', 'seller' => 'Kenji Sato', 'time' => 'Hace 1 día'],
            ['title' => 'Reebok Classic', 'price' => 85, 'image' => 'https://images.unsplash.com/photo-1582588678413-dbf45f4823e9?auto=format&fit=crop&q=80&w=400', 'seller' => 'Emma Watson', 'time' => 'Hace 3 días'],
        ];

        return view('home', compact('popularProducts', 'recommendedProducts'));
    }
}
