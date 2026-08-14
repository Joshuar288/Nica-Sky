<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MyProfileController extends Controller
{
    public function show(Request $request)
    {
        // Carga la ciudad y los productos con sus imágenes y categorías
        $user = $request->user()->load(['city', 'products' => function ($query) {
            $query->with(['images', 'category'])->latest();
        }]);

        // ES CRUCIAL QUE $user VAYA EN EL COMPACT
        return view('myprofile.show', compact('user'));
    }

    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
}