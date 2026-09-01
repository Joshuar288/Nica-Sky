<x-sidebar-layout>
    <x-slot:title>{{ $user->name_bussines ?? $user->name }} - NicaSky</x-slot:title>

    <section class="max-w-7xl mx-auto py-6">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-col md:flex-row gap-6 items-start">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name_bussines ?? $user->name) }}&background=0b132a&color=fff&size=128"
                     alt="{{ $user->name }}"
                     class="w-28 h-28 rounded-full object-cover border-2 border-gray-100 shadow-sm">

                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $user->name_bussines ?? $user->name }}</h1>
                        @if($user->is_verified)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-50 text-[#1d3557] text-xs font-semibold">
                                <i class="bi bi-patch-check-fill"></i>Premium
                            </span>
                        @endif
                    </div>
                    @if($user->name_bussines)
                        <p class="text-sm text-gray-500 mt-1">Atendido por {{ $user->name }}</p>
                    @endif

                    <div class="flex flex-wrap gap-x-5 gap-y-2 mt-4 text-sm text-gray-500">
                        @if($user->city)
                            <span><i class="bi bi-geo-alt mr-1"></i>{{ $user->city->name_city }}, {{ $user->city->name_departament }}</span>
                        @endif
                        <span><i class="bi bi-telephone mr-1"></i>{{ $user->phone }}</span>
                        <span><i class="bi bi-envelope mr-1"></i>{{ $user->email }}</span>
                    </div>

                    @if($user->description)
                        <p class="mt-5 pt-5 border-t border-gray-100 text-sm leading-7 text-gray-600 whitespace-pre-line">{{ $user->description }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-end justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Publicaciones</h2>
                <p class="text-sm text-gray-400 mt-1">Productos publicados por este vendedor.</p>
            </div>
            <span class="text-sm font-semibold text-gray-500">{{ $products->total() }} productos</span>
        </div>

        <div class="grid grid-cols-[repeat(auto-fill,minmax(240px,1fr))] gap-6">
            @forelse($products as $product)
                <article class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col group hover:shadow-md transition">
                    <a href="{{ route('product.show', $product) }}" class="h-44 rounded-xl overflow-hidden mb-4 bg-gray-50 flex items-center justify-center relative">
                        @if($product->images->isNotEmpty())
                            <img src="{{ $product->images->first()->url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <i class="bi bi-image text-3xl text-gray-300"></i>
                        @endif
                        <span class="absolute bottom-2 right-2 px-2 py-0.5 bg-white/90 rounded-md text-[10px] font-bold text-gray-700">{{ $product->state }}</span>
                    </a>
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <a href="{{ route('product.show', $product) }}" class="min-w-0 flex-1 font-bold text-gray-900 text-sm truncate hover:text-[#1d3557]" title="{{ $product->title }}">{{ $product->title }}</a>
                        <span class="shrink-0 font-bold text-[#1d3557] text-sm">C$ {{ number_format($product->price, 2) }}</span>
                    </div>
                    <p class="text-xs text-gray-400 line-clamp-2">{{ $product->description }}</p>
                </article>
            @empty
                <div class="col-span-full bg-white rounded-3xl border border-dashed border-gray-200 py-16 text-center">
                    <i class="bi bi-box-seam text-4xl text-gray-300"></i>
                    <p class="text-sm text-gray-400 mt-3">Este usuario todavía no tiene publicaciones.</p>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="mt-8 pb-4">{{ $products->onEachSide(1)->links() }}</div>
        @endif
    </section>
</x-sidebar-layout>
