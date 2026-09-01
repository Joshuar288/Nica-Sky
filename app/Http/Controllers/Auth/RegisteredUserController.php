<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $cities = City::orderBy('name_city')->get();

        $departments = City::select('name_departament')
                        ->distinct()
                        ->orderBy('name_departament')
                        ->pluck('name_departament');
        return view('auth.register', compact('cities', 'departments'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone'         => ['required', 'string', 'max:20'],
            'city_id'       => ['required', 'exists:cities,id'],
            'name_bussines' => ['nullable', 'string', 'max:255'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'city_id'       => $request->city_id,
            'name_bussines' => $request->name_bussines,
            'is_verified'   => false,
            'role'          => 'user',
            'password'      => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->intended(route('home'));
    }
}
