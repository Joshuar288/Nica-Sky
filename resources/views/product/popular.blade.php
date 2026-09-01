<x-sidebar-layout>
    <x-slot:title>Productos populares - NicaSky</x-slot:title>

    <section class="max-w-7xl mx-auto py-6">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Productos populares</h1>
                <p class="text-sm text-gray-400 mt-1">Una selección al azar entre los 50 productos más visitados.</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#0b132a] transition">
                <i class="bi bi-arrow-left"></i>
                Volver al inicio
            </a>
        </div>

        <div class="grid grid-cols-[repeat(auto-fill,minmax(240px,1fr))] gap-6">
            @forelse($popularProducts as $product)
                <article class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between relative group hover:shadow-md transition">
                    <button type="button" class="absolute top-6 left-6 z-10 w-8 h-8 bg-[#0b132a] text-white rounded-full flex items-center justify-center shadow-md hover:scale-105 transition">
                        <i class="bi bi-cart text-xs"></i>
                    </button>

                    <a href="{{ route('product.show', $product) }}" class="h-44 rounded-xl overflow-hidden mb-4 bg-gray-50 flex items-center justify-center relative" aria-label="Ver detalles de {{ $product->title }}">
                        @if($product->images->isNotEmpty())
                            <img src="{{ $product->images->first()->url }}"
                                 alt="{{ $product->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <i class="bi bi-image text-3xl text-gray-300"></i>
                        @endif

                        <span class="absolute bottom-2 right-2 px-2 py-0.5 bg-white/90 backdrop-blur-md rounded-md text-[10px] font-bold text-gray-700 shadow-sm">
                            {{ $product->state }}
                        </span>
                    </a>

                    <div>
                        <div class="flex justify-between items-center gap-3 mb-1">
                            <h2 class="min-w-0 flex-1 font-bold text-gray-900 text-sm truncate" title="{{ $product->title }}">{{ $product->title }}</h2>
                            <span class="shrink-0 font-bold text-[#1d3557] text-sm">C$ {{ number_format($product->price, 2) }}</span>
                        </div>

                        <p class="text-xs text-gray-400 line-clamp-2 mb-4">{{ $product->description }}</p>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-400">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="w-5 h-5 rounded-full bg-gray-300 overflow-hidden shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($product->user->name) }}&background=random"
                                         alt="{{ $product->user->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                                <a href="{{ route('users.show', $product->user) }}" class="truncate max-w-[90px] hover:text-[#1d3557] hover:underline">{{ $product->user->name }}</a>
                            </div>
                            <span class="inline-flex items-center gap-1">
                                <i class="bi bi-eye"></i>{{ number_format($product->views_count) }}
                            </span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full bg-white border border-gray-100 rounded-3xl py-16 px-6 text-center shadow-sm">
                    <i class="bi bi-box-seam text-4xl text-gray-300"></i>
                    <h2 class="text-xl font-bold text-gray-900 mt-4">Todavía no hay productos populares</h2>
                </div>
            @endforelse
        </div>
    </section>
</x-sidebar-layout>
