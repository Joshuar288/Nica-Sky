<x-sidebar-layout>
    <x-slot:title>
        NicaSky - Productos
    </x-slot:title>

    <section class="h-auto flex gap-8">
        <section class="p-5 w-64 h-full absolute">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Filtros</h2>

            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Precios</h3>
            @for($i = 1; $i <= 4; $i++)
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="radio" name="priceFilter" value="{{$i * $partPrice}}" class="mr-2">
                    Hasta C$ {{ number_format($i * $partPrice) }}
                </label>
            @endfor

            <!-- Indicador de precio seleccionado -->
            <div class="bg-white border border-gray-100 rounded-lg p-2 text-center text-xs font-semibold text-slate-700 shadow-sm">
                Hasta: <span id="priceLabel">C$ {{ number_format($selectedPrice, 2) }}</span>
            </div>
             
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Ciudad</h3>
            <select name="cityFilter" id="cityFilter" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-600">
                <option value="">Todas las ciudades</option>
                @foreach($products as $product)
                    @if($product->user && $product->user->city)
                        <option value="{{ $product->user->city->name_departament }}">
                            {{ $product->user->city->name_departament }}
                        </option>
                    @endif
                @endforeach
            </select>

            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Categoria</h3>
            @foreach($categories as $category)
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="categoryFilter[]" value="{{ $category->id }}" class="mr-2">
                    {{ $category->name }}
                </label>
            @endforeach
        </section>

        <section class="flex-1 grid grid-cols-[repeat(auto-fill,minmax(240px,1fr))] gap-6 pt-2 overflow-y-auto ml-72">
                        @foreach($products as $product)
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between relative group hover:shadow-md transition">
                    <!-- Boton Carrito -->
                    <button class="absolute top-6 left-6 z-10 w-8 h-8 bg-[#0b132a] text-white rounded-full flex items-center justify-center shadow-md hover:scale-105 transition">
                        <i class="bi bi-cart text-xs"></i>
                    </button>

                    <!-- Imagen del Producto -->
                    <div class="h-44 rounded-xl overflow-hidden mb-4 bg-gray-50 flex items-center justify-center relative">
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
                    </div>

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
        </section>
    </section>

</x-sidebar-layout>