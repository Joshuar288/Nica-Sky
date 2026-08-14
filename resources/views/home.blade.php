<x-sidebar-layout>
    <x-slot:title>
        NicaSky - Inicio
    </x-slot:title>

        <!-- Sección: Productos Populares -->
        <section class="mb-10">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-bold text-gray-900">Productos Populares</h2>
                <div class="flex gap-2">
                    <button class="w-8 h-8 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-600 hover:bg-gray-50"><i class="bi bi-chevron-left"></i></button>
                    <button class="w-8 h-8 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-600 hover:bg-gray-50"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>

            <!-- Grilla de Tarjetas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($popularProducts as $product)
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between relative group">
                        <button class="absolute top-6 left-6 z-10 w-8 h-8 bg-[#0b132a] text-white rounded-full flex items-center justify-center shadow-md hover:scale-105 transition">
                            <i class="bi bi-cart text-xs"></i>
                        </button>
                        <div class="h-44 rounded-xl overflow-hidden mb-4 bg-gray-50">
                            <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="font-bold text-gray-900 text-sm">{{ $product['title'] }}</h3>
                                <span class="font-bold text-[#1d3557] text-sm">${{ $product['price'] }}</span>
                            </div>
                            <p class="text-xs text-gray-400 line-clamp-2 mb-4">Disfruta del estilo icónico y la comodidad duradera de estos tenis clásicos.</p>
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-400">
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-gray-300 overflow-hidden">
                                        <img src="https://i.pravatar.cc/100?u={{ urlencode($product['seller']) }}" class="w-full h-full object-cover">
                                    </div>
                                    <span>{{ $product['seller'] }}</span>
                                </div>
                                <span>{{ $product['time'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-center mt-6">
                <button class="px-6 py-2.5 bg-white border border-gray-200 rounded-full text-xs font-semibold text-gray-700 hover:bg-gray-50 flex items-center gap-2 shadow-sm transition">
                    Ver todo <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </section>

        <!-- Sección: Productos Recomendados -->
        <section>
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-bold text-gray-900">Productos Recomendados</h2>
                <div class="flex gap-2">
                    <button class="w-8 h-8 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-600 hover:bg-gray-50"><i class="bi bi-chevron-left"></i></button>
                    <button class="w-8 h-8 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-600 hover:bg-gray-50"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recommendedProducts as $product)
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between relative group">
                        <button class="absolute top-6 left-6 z-10 w-8 h-8 bg-[#0b132a] text-white rounded-full flex items-center justify-center shadow-md hover:scale-105 transition">
                            <i class="bi bi-cart text-xs"></i>
                        </button>
                        <div class="h-44 rounded-xl overflow-hidden mb-4 bg-gray-50">
                            <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="font-bold text-gray-900 text-sm">{{ $product['title'] }}</h3>
                                <span class="font-bold text-[#1d3557] text-sm">${{ $product['price'] }}</span>
                            </div>
                            <p class="text-xs text-gray-400 line-clamp-2 mb-4">El equilibrio perfecto entre rendimiento retro y confort moderno.</p>
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-400">
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-gray-300 overflow-hidden">
                                        <img src="https://i.pravatar.cc/100?u={{ urlencode($product['seller']) }}" class="w-full h-full object-cover">
                                    </div>
                                    <span>{{ $product['seller'] }}</span>
                                </div>
                                <span>{{ $product['time'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-center mt-6">
                <button class="px-6 py-2.5 bg-white border border-gray-200 rounded-full text-xs font-semibold text-gray-700 hover:bg-gray-50 flex items-center gap-2 shadow-sm transition">
                    Ver todo <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </section>
</x-sidebar-layout>