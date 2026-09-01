<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PremiumController extends Controller
{
    private const PLANS = [
        'pro_1' => ['name' => 'Plan plus', 'price' => 199, 'recommended' => 'Hasta 5 productos recomendados'],
        'pro_2' => ['name' => 'Plan Pro', 'price' => 399, 'recommended' => 'Hasta 15 productos recomendados'],
        'pro_3' => ['name' => 'Plan Nica', 'price' => 699, 'recommended' => 'Todos tus productos recomendados'],
    ];

    public function show(Request $request): View
    {
        return view('premium.show', ['user' => $request->user()]);
    }

    public function checkout(Request $request, string $plan): View|RedirectResponse
    {
        if (! array_key_exists($plan, self::PLANS)) {
            return redirect()->route('premium.show')
                ->withErrors(['plan' => 'El plan seleccionado no existe.']);
        }

        $planRanks = ['free' => 0, 'pro_1' => 1, 'pro_2' => 2, 'pro_3' => 3];
        $currentPlan = $request->user()->plan;

        if ($planRanks[$plan] <= ($planRanks[$currentPlan] ?? 0)) {
            return redirect()->route('premium.show')
                ->withErrors(['plan' => 'Solo puedes comprar un plan superior al que tienes actualmente.']);
        }

        return view('premium.checkout', [
            'planKey' => $plan,
            'plan' => self::PLANS[$plan],
        ]);
    }

    public function purchase(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plan' => ['required', Rule::in(['pro_1', 'pro_2', 'pro_3'])],
            'card_name' => ['required', 'string', 'max:100'],
            'card_number' => ['required', 'string', 'regex:/^\d{16}$/'],
            'expiration' => [
                'required',
                'regex:/^(0[1-9]|1[0-2])\/\d{2}$/',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $expiration = \DateTimeImmutable::createFromFormat('!m/y', $value);

                    if (! $expiration || $expiration->modify('last day of this month 23:59:59') < new \DateTimeImmutable()) {
                        $fail('La fecha de vencimiento debe corresponder al mes actual o a uno posterior.');
                    }
                },
            ],
            'cvv' => ['required', 'digits_between:3,4'],
        ]);

        $planRanks = ['free' => 0, 'pro_1' => 1, 'pro_2' => 2, 'pro_3' => 3];
        $user = $request->user();

        if ($planRanks[$validated['plan']] <= ($planRanks[$user->plan] ?? 0)) {
            return redirect()->route('premium.show')
                ->withErrors(['plan' => 'Solo puedes comprar un plan superior al que tienes actualmente.']);
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
