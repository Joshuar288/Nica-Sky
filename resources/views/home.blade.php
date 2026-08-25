<x-sidebar-layout>
    <x-slot:title>
        NicaSky - Inicio
    </x-slot:title>

    <section class= "section-popular-products" id="popular-products">
        <div class= "header-section">
            <h2 class= "title-section">Productos Populares</h2>
            <div class="section-nextprev">
                <button class= "btn-section" id="btn-prev"><</button>
                <button class= "btn-section" id="btn-next">></button>
            </div>
        </div>

        <div class= "body-section-carousel" id="carousell-1">
            @foreach($popularProducts as $product)
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col flex-[0_0_calc(25%-1.6rem)] justify-between relative group hover:shadow-md transition">
                    <!-- Boton Carrito -->
                    <button class="absolute top-6 left-6 z-10 w-8 h-8 bg-[#0b132a] text-white rounded-full flex items-center justify-center shadow-md hover:scale-105 transition">
                        <i class="bi bi-cart text-xs"></i>
                    </button>

                    <!-- Imagen del Producto -->
                    <a href="{{ route('product.show', $product) }}" class="h-44 rounded-xl overflow-hidden mb-4 bg-gray-50 flex items-center justify-center relative" aria-label="Ver detalles de {{ $product->title }}">
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->rute) }}"
                                 alt="{{ $product->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <i class="bi bi-image text-3xl text-gray-300"></i>
                        @endif

                        @if(isset($product->state))
                            <span class="absolute bottom-2 right-2 px-2 py-0.5 bg-white/90 backdrop-blur-md rounded-md text-[10px] font-bold text-gray-700 shadow-sm">
                                {{ $product->state }}
                            </span>
                        @endif
                    </a>

                    <!-- Informacion del Producto -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="font-bold text-gray-900 text-sm truncate" title="{{ $product->title }}">{{ $product->title }}</h3>
                            <span class="font-bold text-[#1d3557] text-sm">C$ {{ number_format($product->price, 2) }}</span>
                        </div>

                        <p class="text-xs text-gray-400 line-clamp-2 mb-4">{{ $product->description }}</p>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-400">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full bg-gray-300 overflow-hidden shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($product->user->name) }}&background=random" class="w-full h-full object-cover">
                                </div>
                                <span class="truncate max-w-[90px]">{{ $product->user->name }}</span>
                            </div>
                            <span>• {{ $product->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-center mt-6">
            <a href="#" class="px-3 py-2 bg-gray-50 border border-gray-400 text-[#0b132a] rounded-3xl hover:bg-gray-200 transition">Ver más productos</a>
        </div>
    </section>

    <section class= "section-popular-products" id="popular-products">
        <div class= "header-section">
            <h2 class= "title-section">Productos Recomendados</h2>
            <div class="section-nextprev">
                <button class= "btn-section" id="btn-prev2"><</button>
                <button class= "btn-section" id="btn-next2">></button>
            </div>
        </div>

        <div class= "body-section-carousel" id="carousell-2">
            @foreach($recommendedProducts as $product)
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col flex-[0_0_calc(25%-1.6rem)] justify-between relative group hover:shadow-md transition">
                    <!-- Boton Carrito -->
                    <button class="absolute top-6 left-6 z-10 w-8 h-8 bg-[#0b132a] text-white rounded-full flex items-center justify-center shadow-md hover:scale-105 transition">
                        <i class="bi bi-cart text-xs"></i>
                    </button>

                    <!-- Imagen del Producto -->
                    <a href="{{ route('product.show', $product) }}" class="h-44 rounded-xl overflow-hidden mb-4 bg-gray-50 flex items-center justify-center relative" aria-label="Ver detalles de {{ $product->title }}">
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->rute) }}"
                                 alt="{{ $product->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <i class="bi bi-image text-3xl text-gray-300"></i>
                        @endif

                        @if(isset($product->state))
                            <span class="absolute bottom-2 right-2 px-2 py-0.5 bg-white/90 backdrop-blur-md rounded-md text-[10px] font-bold text-gray-700 shadow-sm">
                                {{ $product->state }}
                            </span>
                        @endif
                    </a>

                    <!-- Informacion del Producto -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="font-bold text-gray-900 text-sm truncate" title="{{ $product->title }}">{{ $product->title }}</h3>
                            <span class="font-bold text-[#1d3557] text-sm">C$ {{ number_format($product->price, 2) }}</span>
                        </div>

                        <p class="text-xs text-gray-400 line-clamp-2 mb-4">{{ $product->description }}</p>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-400">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full bg-gray-300 overflow-hidden shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($product->user->name) }}&background=random" class="w-full h-full object-cover">
                                </div>
                                <span class="truncate max-w-[90px]">{{ $product->user->name }}</span>
                            </div>
                            <span>• {{ $product->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-center mt-6">
            <a href="#" class="px-3 py-2 bg-gray-50 border border-gray-400 text-[#0b132a] rounded-3xl hover:bg-gray-200 transition">Ver más productos</a>
        </div>
    </section>
</x-sidebar-layout>
