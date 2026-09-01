<x-sidebar-layout>
    <x-slot:title>Finalizar compra - NicaSky</x-slot:title>

    <section class="max-w-6xl mx-auto py-6">
        <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 mb-6 text-sm font-semibold text-gray-500 hover:text-[#0b132a] transition">
            <i class="bi bi-arrow-left"></i>
            Volver al carrito
        </a>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Finalizar compra</h1>
            <p class="text-sm text-gray-400 mt-1">Completa tus datos para preparar el pago.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8 items-start">
            <form id="payment-form" action="{{ route('cart.checkout.process') }}" method="POST" class="bg-white border border-gray-100 rounded-3xl p-6 lg:p-8 shadow-sm">
                @csrf
                @if($errors->any())
                    <div class="mb-6 rounded-2xl bg-red-50 border border-red-100 p-4 text-sm text-red-700">
                        Revisa los datos ingresados antes de confirmar el pago.
                    </div>
                @endif
                <fieldset class="mb-8">
                    <legend class="text-lg font-bold text-gray-900 mb-5">Información de contacto</legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nombre completo</label>
                            <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" autocomplete="name" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Correo electrónico</label>
                            <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" autocomplete="email" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Teléfono</label>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone', auth()->user()->phone) }}" autocomplete="tel" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Dirección de entrega</label>
                            <input id="address" name="address" type="text" value="{{ old('address') }}" autocomplete="street-address" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border-t border-gray-100 pt-8">
                    <legend class="text-lg font-bold text-gray-900 mb-5">Datos de la tarjeta</legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label for="card-name" class="block text-sm font-semibold text-gray-700 mb-2">Nombre en la tarjeta</label>
                            <input id="card-name" name="card_name" type="text" autocomplete="cc-name" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="card-number" class="block text-sm font-semibold text-gray-700 mb-2">Número de tarjeta</label>
                            <div class="relative">
                                <input id="card-number" name="card_number" type="text" inputmode="numeric" autocomplete="cc-number" placeholder="0000 0000 0000 0000" maxlength="19" required class="w-full pl-4 pr-12 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                                <i class="bi bi-credit-card absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label for="expiration" class="block text-sm font-semibold text-gray-700 mb-2">Vencimiento</label>
                            <input id="expiration" name="expiration" type="text" inputmode="numeric" autocomplete="cc-exp" placeholder="MM/AA" maxlength="5" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                        </div>
                        <div>
                            <label for="cvv" class="block text-sm font-semibold text-gray-700 mb-2">CVV</label>
                            <input id="cvv" name="cvv" type="password" inputmode="numeric" autocomplete="cc-csc" maxlength="4" placeholder="123" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                        </div>
                    </div>
                </fieldset>
            </form>

            <aside class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm lg:sticky lg:top-24">
                <h2 class="text-lg font-bold text-gray-900 mb-5">Resumen del pedido</h2>
                <div class="space-y-4 max-h-72 overflow-y-auto pr-1">
                    @foreach($products as $product)
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 shrink-0 rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center">
                                @if($product->images->isNotEmpty())
                                    <img src="{{ $product->images->first()->url }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                @else
                                    <i class="bi bi-image text-gray-300"></i>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $product->title }}</p>
                                <p class="text-xs text-gray-400">Cantidad: {{ $product->cart_quantity }}</p>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">C$ {{ number_format($product->cart_subtotal, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-between mt-6 pt-5 border-t border-gray-100">
                    <span class="font-bold text-gray-900">Total</span>
                    <span class="text-xl font-bold text-[#1d3557]">C$ {{ number_format($total, 2) }}</span>
                </div>

                <button type="submit" form="payment-form" class="mt-6 w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#0b132a] hover:bg-[#162038] text-white rounded-full text-sm font-semibold transition">
                    <i class="bi bi-lock"></i>
                    Confirmar pago
                </button>
            </aside>
        </div>
    </section>

    <script>
        const cardNumberInput = document.getElementById('card-number');
        const expirationInput = document.getElementById('expiration');
        const cvvInput = document.getElementById('cvv');

        cardNumberInput?.addEventListener('input', (event) => {
            const digits = event.target.value.replace(/\D/g, '').slice(0, 16);
            event.target.value = digits.replace(/(.{4})/g, '$1 ').trim();
        });

        expirationInput?.addEventListener('input', (event) => {
            const digits = event.target.value.replace(/\D/g, '').slice(0, 4);
            event.target.value = digits.length > 2
                ? `${digits.slice(0, 2)}/${digits.slice(2)}`
                : digits;
        });

        cvvInput?.addEventListener('input', (event) => {
            event.target.value = event.target.value.replace(/\D/g, '').slice(0, 4);
        });
    </script>
</x-sidebar-layout>
