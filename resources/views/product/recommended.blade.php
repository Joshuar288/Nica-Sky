<x-sidebar-layout>
    <x-slot:title>Productos recomendados - NicaSky</x-slot:title>

    <section class="max-w-7xl mx-auto py-6">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Productos recomendados</h1>
                <p class="text-sm text-gray-400 mt-1">Publicaciones destacadas de vendedores Premium.</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#0b132a] transition">
                <i class="bi bi-arrow-left"></i>Volver al inicio
            </a>
        </div>

        <div class="grid grid-cols-[repeat(auto-fill,minmax(240px,1fr))] gap-6">
            @forelse($recommendedProducts as $product)
                <article class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between relative group hover:shadow-md transition">
                    <span class="absolute top-6 left-6 z-10 inline-flex items-center gap-1 px-2.5 py-1 bg-[#0b132a] text-white rounded-full text-[10px] font-semibold shadow-md">
                        <i class="bi bi-gem"></i>Premium
                    </span>

                    <a href="{{ route('product.show', $product) }}" class="h-44 rounded-xl overflow-hidden mb-4 bg-gray-50 flex items-center justify-center relative" aria-label="Ver detalles de {{ $product->title }}">
                        @if($product->images->isNotEmpty())
                            <img src="{{ $product->images->first()->url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <i class="bi bi-image text-3xl text-gray-300"></i>
                        @endif
                        <span class="absolute bottom-2 right-2 px-2 py-0.5 bg-white/90 rounded-md text-[10px] font-bold text-gray-700 shadow-sm">{{ $product->state }}</span>
                    </a>

                    <div>
                        <div class="flex justify-between items-center gap-3 mb-1">
                            <h2 class="font-bold text-gray-900 text-sm truncate" title="{{ $product->title }}">{{ $product->title }}</h2>
                            <span class="shrink-0 font-bold text-[#1d3557] text-sm">C$ {{ number_format($product->price, 2) }}</span>
                        </div>
                        <p class="text-xs text-gray-400 line-clamp-2 mb-4">{{ $product->description }}</p>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-400">
                            <div class="flex items-center gap-2 min-w-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($product->user->name) }}&background=random" alt="{{ $product->user->name }}" class="w-5 h-5 rounded-full object-cover">
                                <a href="{{ route('users.show', $product->user) }}" class="truncate max-w-[110px] hover:text-[#1d3557] hover:underline">{{ $product->user->name }}</a>
                            </div>
                            <span>{{ $product->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full bg-white border border-gray-100 rounded-3xl py-16 px-6 text-center shadow-sm">
                    <i class="bi bi-gem text-4xl text-gray-300"></i>
                    <h2 class="text-xl font-bold text-gray-900 mt-4">Todavía no hay productos recomendados</h2>
                    <p class="text-sm text-gray-400 mt-2">Los productos de vendedores Premium aparecerán aquí.</p>
                </div>
            @endforelse
        </div>

        @if($recommendedProducts->hasPages())
            <div class="mt-8">{{ $recommendedProducts->links() }}</div>
        @endif
    </section>
</x-sidebar-layout>
