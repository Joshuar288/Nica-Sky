<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PremiumController extends Controller
{
    public function show(Request $request): View
    {
        return view('premium.show', ['user' => $request->user()]);
    }

    public function purchase(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plan' => ['required', Rule::in(['pro_1', 'pro_2', 'pro_3'])],
        ]);

        $planRanks = ['free' => 0, 'pro_1' => 1, 'pro_2' => 2, 'pro_3' => 3];
        $user = $request->user();

        if ($planRanks[$validated['plan']] < $planRanks[$user->plan]) {
            return back()->withErrors(['plan' => 'No puedes cambiar a un plan inferior desde esta pantalla.']);
        }

        $user->update([
            'plan' => $validated['plan'],
            'is_verified' => true,
        ]);

        if ($validated['plan'] === 'pro_3') {
            $user->products()->update(['is_recommended' => true]);
        }

        return redirect()->route('premium.show')
            ->with('success', 'Tu nuevo plan fue activado correctamente.');
    }
}
