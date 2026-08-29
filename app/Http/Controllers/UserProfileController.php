<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    public function show(User $user): View
    {
        $user->load('city');

        $products = $user->products()
            ->with(['images', 'category'])
            ->latest()
            ->paginate(12);

        return view('myprofile.public', compact('user', 'products'));
    }
}
