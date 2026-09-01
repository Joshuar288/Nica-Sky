<x-sidebar-layout>
    <x-slot:title>Pago del plan - NicaSky</x-slot:title>

    <section class="max-w-5xl mx-auto py-6">
        <a href="{{ route('premium.show') }}" class="inline-flex items-center gap-2 mb-6 text-sm font-semibold text-gray-500 hover:text-[#0b132a] transition">
            <i class="bi bi-arrow-left"></i>
            Volver a los planes
        </a>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Completar pago del plan</h1>
            <p class="text-sm text-gray-400 mt-1">Ingresa los datos para simular la compra de tu suscripción mensual.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-8 items-start">
            <form id="premium-payment-form" action="{{ route('premium.purchase') }}" method="POST" class="bg-white border border-gray-100 rounded-3xl p-6 lg:p-8 shadow-sm">
                @csrf
                <input type="hidden" name="plan" value="{{ $planKey }}">

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl bg-red-50 border border-red-100 p-4 text-sm text-red-700">
                        Revisa los datos ingresados antes de confirmar el pago.
                    </div>
                @endif

                <fieldset>
                    <legend class="text-lg font-bold text-gray-900 mb-5">Datos de la tarjeta</legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label for="card-name" class="block text-sm font-semibold text-gray-700 mb-2">Nombre en la tarjeta</label>
                            <input id="card-name" name="card_name" type="text" value="{{ old('card_name') }}" autocomplete="cc-name" required maxlength="100" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                            @error('card_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="card-number" class="block text-sm font-semibold text-gray-700 mb-2">Número de tarjeta</label>
                            <div class="relative">
                                <input id="card-number" name="card_number" type="text" inputmode="numeric" autocomplete="cc-number" placeholder="0000 0000 0000 0000" required maxlength="19" class="w-full pl-4 pr-12 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                                <i class="bi bi-credit-card absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('card_number')<p class="text-xs text-red-500 mt-1">El número de tarjeta debe contener 16 dígitos.</p>@enderror
                        </div>

                        <div>
                            <label for="expiration" class="block text-sm font-semibold text-gray-700 mb-2">Vencimiento</label>
                            <input id="expiration" name="expiration" type="text" value="{{ old('expiration') }}" inputmode="numeric" autocomplete="cc-exp" placeholder="MM/AA" required maxlength="5" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                            @error('expiration')<p class="text-xs text-red-500 mt-1">Ingresa una fecha vigente en formato MM/AA.</p>@enderror
                        </div>

                        <div>
                            <label for="cvv" class="block text-sm font-semibold text-gray-700 mb-2">CVV</label>
                            <input id="cvv" name="cvv" type="password" inputmode="numeric" autocomplete="cc-csc" maxlength="4" placeholder="123" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                            @error('cvv')<p class="text-xs text-red-500 mt-1">El CVV debe tener 3 o 4 dígitos.</p>@enderror
                        </div>
                    </div>
                </fieldset>

                <div class="mt-7 flex items-start gap-3 rounded-2xl bg-amber-50 border border-amber-100 p-4 text-xs leading-5 text-amber-800">
                    <i class="bi bi-info-circle mt-0.5"></i>
                    <p>Por seguridad, los datos de la tarjeta no se almacenan en la plataforma.</p>
                </div>
            </form>

            <aside class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm lg:sticky lg:top-24">
                <span class="inline-flex items-center gap-2 text-xs font-semibold text-[#1d3557]"><i class="bi bi-gem"></i> Plan seleccionado</span>
                <h2 class="text-2xl font-bold text-gray-900 mt-4">{{ $plan['name'] }}</h2>
                <p class="text-sm text-gray-500 mt-2">{{ $plan['recommended'] }}</p>
                <p class="text-xs text-gray-400 mt-6">Pago mensual</p>
                <div class="flex items-end justify-between mt-1 pb-5 border-b border-gray-100">
                    <span class="font-semibold text-gray-700">Total</span>
                    <span class="text-2xl font-bold text-[#1d3557]">C$ {{ number_format($plan['price'], 2) }}</span>
                </div>
                <button type="submit" form="premium-payment-form" class="mt-6 w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#0b132a] hover:bg-[#162038] text-white rounded-full text-sm font-semibold transition">
                    <i class="bi bi-lock"></i>
                    Confirmar pago
                </button>
            </aside>
        </div>
    </section>

    <script>
        document.getElementById('card-number')?.addEventListener('input', (event) => {
            const digits = event.target.value.replace(/\D/g, '').slice(0, 16);
            event.target.value = digits.replace(/(.{4})/g, '$1 ').trim();
        });

        document.getElementById('expiration')?.addEventListener('input', (event) => {
            const digits = event.target.value.replace(/\D/g, '').slice(0, 4);
            event.target.value = digits.length > 2 ? `${digits.slice(0, 2)}/${digits.slice(2)}` : digits;
        });

        document.getElementById('premium-payment-form')?.addEventListener('submit', () => {
            const cardNumber = document.getElementById('card-number');
            cardNumber.value = cardNumber.value.replace(/\D/g, '');
        });
    </script>
</x-sidebar-layout>
