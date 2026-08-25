<x-sidebar-layout>
    <x-slot:title>
        {{ $product->title }} - NicaSky
    </x-slot:title>

    <section class="max-w-6xl mx-auto py-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 mb-6 text-sm font-semibold text-gray-500 hover:text-[#0b132a] transition">
            <i class="bi bi-arrow-left"></i>
            Volver
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 bg-white rounded-3xl border border-gray-100 p-6 lg:p-8 shadow-sm">
            <div class="rounded-2xl overflow-hidden bg-gray-50 min-h-[320px] lg:min-h-[480px] flex items-center justify-center">
                @if($product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $product->images->first()->rute) }}"
                         alt="{{ $product->title }}"
                         class="w-full h-full max-h-[560px] object-cover">
                @else
                    <div class="flex flex-col items-center gap-3 text-gray-300">
                        <i class="bi bi-image text-6xl"></i>
                        <span class="text-sm">Producto sin imagen</span>
                    </div>
                @endif
            </div>

            <div class="flex flex-col">
                <div class="flex flex-wrap gap-2 mb-4">
                    @if($product->category)
                        <span class="px-3 py-1 bg-blue-50 text-[#1d3557] rounded-full text-xs font-semibold">
                            {{ $product->category->name }}
                        </span>
                    @endif
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">
                        {{ $product->state }}
                    </span>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $product->title }}</h1>
                <p class="text-3xl font-bold text-[#1d3557] mb-6">
                    C$ {{ number_format($product->price, 2) }}
                    <span class="text-sm font-normal text-gray-400">/ {{ $product->unit }}</span>
                </p>

                <div class="border-t border-gray-100 pt-6 mb-8">
                    <h2 class="font-bold text-gray-900 mb-3">Descripción</h2>
                    <p class="text-sm leading-7 text-gray-600 whitespace-pre-line">{{ $product->description }}</p>
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8 text-sm">
                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-gray-400 mb-1">Disponibilidad</dt>
                        <dd class="font-semibold text-gray-800">
                            {{ is_null($product->stock) ? 'Consultar' : $product->stock . ' disponibles' }}
                        </dd>
                    </div>
                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-gray-400 mb-1">Publicado</dt>
                        <dd class="font-semibold text-gray-800">{{ $product->created_at->diffForHumans() }}</dd>
                    </div>
                    <div class="rounded-xl bg-gray-50 p-4">
                        <dt class="text-gray-400 mb-1">Visitas</dt>
                        <dd class="font-semibold text-gray-800">
                            <i class="bi bi-eye mr-1 text-gray-400"></i>{{ number_format($product->views_count) }}
                        </dd>
                    </div>
                </dl>

                <div class="mt-auto border-t border-gray-100 pt-6 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($product->user->name) }}&background=random"
                             alt="{{ $product->user->name }}"
                             class="w-11 h-11 rounded-full object-cover">
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $product->user->name }}</p>
                            @if($product->user->city)
                                <p class="text-xs text-gray-400">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $product->user->city->name_departament }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('cart.store', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="shrink-0 inline-flex items-center gap-2 px-5 py-3 bg-[#0b132a] hover:bg-[#162038] text-white rounded-full text-sm font-semibold transition">
                            <i class="bi bi-cart-plus"></i>
                            Añadir al carrito
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mt-5 px-5 py-4 rounded-2xl bg-green-50 border border-green-100 text-sm font-semibold text-green-700">
                <i class="bi bi-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($relatedProducts->isNotEmpty())
            <div class="mt-12">
                <div class="flex items-end justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Productos relacionados</h2>
                        <p class="text-sm text-gray-400 mt-1">
                            Más productos de la categoría {{ $product->category->name }}
                        </p>
                    </div>
                    <a href="{{ route('product.index') }}" class="text-sm font-semibold text-[#1d3557] hover:underline">
                        Ver todos
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <article class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col group hover:shadow-md transition">
                            <a href="{{ route('product.show', $relatedProduct) }}"
                               class="h-44 rounded-xl overflow-hidden mb-4 bg-gray-50 flex items-center justify-center relative"
                               aria-label="Ver detalles de {{ $relatedProduct->title }}">
                                @if($relatedProduct->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $relatedProduct->images->first()->rute) }}"
                                         alt="{{ $relatedProduct->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <i class="bi bi-image text-3xl text-gray-300"></i>
                                @endif

                                <span class="absolute bottom-2 right-2 px-2 py-0.5 bg-white/90 backdrop-blur-md rounded-md text-[10px] font-bold text-gray-700 shadow-sm">
                                    {{ $relatedProduct->state }}
                                </span>
                            </a>

                            <div class="flex items-start justify-between gap-3 mb-2">
                                <a href="{{ route('product.show', $relatedProduct) }}" class="font-bold text-gray-900 text-sm truncate hover:text-[#1d3557]" title="{{ $relatedProduct->title }}">
                                    {{ $relatedProduct->title }}
                                </a>
                                <span class="shrink-0 font-bold text-[#1d3557] text-sm">
                                    C$ {{ number_format($relatedProduct->price, 2) }}
                                </span>
                            </div>

                            <p class="text-xs text-gray-400 line-clamp-2 mb-4">{{ $relatedProduct->description }}</p>

                            <div class="mt-auto flex items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-400">
                                <span class="truncate">{{ $relatedProduct->user->name }}</span>
                                <span>{{ $relatedProduct->created_at->diffForHumans() }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</x-sidebar-layout>
