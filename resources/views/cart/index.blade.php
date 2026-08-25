<x-sidebar-layout>
    <x-slot:title>Mi carrito - NicaSky</x-slot:title>

    <section class="max-w-6xl mx-auto py-6">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Mi carrito</h1>
                <p class="text-sm text-gray-400 mt-1">Revisa los productos que has añadido.</p>
            </div>

            @if($products->isNotEmpty())
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-semibold text-red-500 hover:text-red-700 transition">
                        <i class="bi bi-trash mr-1"></i>Vaciar carrito
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-6 px-5 py-4 rounded-2xl bg-green-50 border border-green-100 text-sm font-semibold text-green-700">
                <i class="bi bi-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($products->isEmpty())
            <div class="bg-white border border-gray-100 rounded-3xl py-20 px-6 text-center shadow-sm">
                <div class="w-16 h-16 mx-auto mb-5 rounded-full bg-gray-50 flex items-center justify-center">
                    <i class="bi bi-bag text-3xl text-gray-300"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Tu carrito está vacío</h2>
                <p class="text-sm text-gray-400 mb-6">Explora el catálogo y añade los productos que te interesen.</p>
                <a href="{{ route('product.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#0b132a] hover:bg-[#162038] text-white rounded-full text-sm font-semibold transition">Ver productos</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8 items-start">
                <div class="space-y-4">
                    @foreach($products as $product)
                        <article class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row gap-5">
                            <a href="{{ route('product.show', $product) }}" class="w-full sm:w-36 h-36 shrink-0 rounded-xl overflow-hidden bg-gray-50 flex items-center justify-center">
                                @if($product->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $product->images->first()->rute) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                @else
                                    <i class="bi bi-image text-3xl text-gray-300"></i>
                                @endif
                            </a>

                            <div class="flex-1 flex flex-col justify-between min-w-0">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <a href="{{ route('product.show', $product) }}" class="font-bold text-gray-900 hover:text-[#1d3557] transition">{{ $product->title }}</a>
                                        <p class="text-sm text-gray-400 mt-1">C$ {{ number_format($product->price, 2) }} / {{ $product->unit }}</p>
                                    </div>
                                    <form action="{{ route('cart.destroy', $product) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-300 hover:text-red-500 transition" aria-label="Eliminar {{ $product->title }}">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="flex flex-wrap items-end justify-between gap-4 mt-5">
                                    <form action="{{ route('cart.update', $product) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label for="quantity-{{ $product->id }}" class="text-xs text-gray-400">Cantidad</label>
                                        <input id="quantity-{{ $product->id }}" name="quantity" type="number" min="1" max="99" value="{{ $product->cart_quantity }}" class="w-16 rounded-lg border-gray-200 text-sm py-2 focus:border-[#1d3557] focus:ring-[#1d3557]">
                                        <button type="submit" class="text-xs font-semibold text-[#1d3557] hover:underline">Actualizar</button>
                                    </form>
                                    <p class="font-bold text-[#1d3557]">C$ {{ number_format($product->cart_subtotal, 2) }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <aside class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm lg:sticky lg:top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-5">Resumen</h2>
                    <div class="flex items-center justify-between text-sm text-gray-500 pb-4 border-b border-gray-100">
                        <span>Productos</span>
                        <span>{{ $products->sum('cart_quantity') }}</span>
                    </div>
                    <div class="flex items-center justify-between mt-5">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="text-xl font-bold text-[#1d3557]">C$ {{ number_format($total, 2) }}</span>
                    </div>
                    <a href="{{ route('cart.checkout') }}" class="mt-6 w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#0b132a] hover:bg-[#162038] text-white rounded-full text-sm font-semibold transition">
                        <i class="bi bi-credit-card"></i>
                        Proceder al pago
                    </a>
                    <p class="text-xs text-gray-400 mt-4">El pago y la entrega se coordinan directamente con cada vendedor.</p>
                </aside>
            </div>
        @endif
    </section>
</x-sidebar-layout>
