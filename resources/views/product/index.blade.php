<x-sidebar-layout>
    <x-slot:title>NicaSky - Productos</x-slot:title>

    <section class="flex flex-col lg:flex-row gap-8 pb-10">
        <aside class="p-5 w-full lg:w-64 shrink-0 lg:sticky lg:top-20 lg:self-start">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Filtros</h2>

            <form action="{{ route('product.index') }}" method="GET" class="space-y-6">
                @if($search !== '')
                    <input type="hidden" name="q" value="{{ $search }}">
                @endif
                <div class="space-y-2">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Precios</h3>
                    @foreach($priceOptions as $priceOption)
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="radio" name="priceFilter" value="{{ $priceOption }}" @checked((float) $selectedPrice === (float) $priceOption) class="text-[#1d3557] focus:ring-[#1d3557]">
                            Hasta C$ {{ number_format($priceOption, 2) }}
                        </label>
                    @endforeach
                    <div class="bg-white border border-gray-100 rounded-lg p-2 text-center text-xs font-semibold text-slate-700 shadow-sm">
                        Hasta: C$ {{ number_format($selectedPrice, 2) }}
                    </div>
                </div>

                <div>
                    <label for="departmentFilter" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Departamento</label>
                    <select name="departmentFilter" id="departmentFilter" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                        <option value="">Todos los departamentos</option>
                        @foreach($departments as $department)
                            <option value="{{ $department }}" @selected($selectedDepartment === $department)>{{ $department }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="cityFilter" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Ciudad</label>
                    <select name="cityFilter" id="cityFilter" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                        <option value="">Todas las ciudades</option>
                        @foreach($cities->groupBy('name_departament') as $department => $departmentCities)
                            <optgroup label="{{ $department }}">
                                @foreach($departmentCities as $city)
                                    <option value="{{ $city->id }}" @selected((int) $selectedCity === $city->id)>{{ $city->name_city }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="categoryFilter" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Categoría</label>
                    <select name="categoryFilter" id="categoryFilter" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected((int) $selectedCategory === $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <button type="submit" class="w-full px-4 py-2.5 bg-[#0b132a] hover:bg-[#162038] text-white rounded-xl text-sm font-semibold transition">Aplicar filtros</button>
                    <a href="{{ $search !== '' ? route('product.index', ['q' => $search]) : route('product.index') }}" class="w-full px-4 py-2.5 text-center border border-gray-200 hover:bg-gray-100 text-gray-600 rounded-xl text-sm font-semibold transition">Limpiar filtros</a>
                </div>
            </form>
        </aside>

        <div class="flex-1 min-w-0 pt-2">
            @if($search !== '')
                <div class="flex flex-wrap items-center justify-between gap-3 mb-5 px-1">
                    <p class="text-sm text-gray-500">
                        {{ $products->total() }} resultados para <span class="font-semibold text-gray-900">“{{ $search }}”</span>
                    </p>
                    <a href="{{ route('product.index') }}" class="text-xs font-semibold text-[#1d3557] hover:underline">Quitar búsqueda</a>
                </div>
            @endif
            <section class="grid grid-cols-[repeat(auto-fill,minmax(240px,1fr))] gap-6">
                @forelse($products as $product)
                    <article class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between relative group hover:shadow-md transition">
                        <button class="absolute top-6 left-6 z-10 w-8 h-8 bg-[#0b132a] text-white rounded-full flex items-center justify-center shadow-md hover:scale-105 transition">
                            <i class="bi bi-cart text-xs"></i>
                        </button>

                        <a href="{{ route('product.show', $product) }}" class="h-44 rounded-xl overflow-hidden mb-4 bg-gray-50 flex items-center justify-center relative" aria-label="Ver detalles de {{ $product->title }}">
                            @if($product->images->isNotEmpty())
                                <img src="{{ $product->images->first()->url }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <i class="bi bi-image text-3xl text-gray-300"></i>
                            @endif

                            <span class="absolute bottom-2 right-2 px-2 py-0.5 bg-white/90 backdrop-blur-md rounded-md text-[10px] font-bold text-gray-700 shadow-sm">
                                {{ $product->state }}
                            </span>
                        </a>

                        <div>
                            <div class="flex justify-between items-center gap-3 mb-1">
                                <h3 class="min-w-0 flex-1 font-bold text-gray-900 text-sm truncate" title="{{ $product->title }}">{{ $product->title }}</h3>
                                <span class="shrink-0 font-bold text-[#1d3557] text-sm">C$ {{ number_format($product->price, 2) }}</span>
                            </div>

                            <p class="text-xs text-gray-400 line-clamp-2 mb-4">{{ $product->description }}</p>

                            <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-400">
                                <div class="flex items-center gap-2 min-w-0">
                                    <div class="w-5 h-5 rounded-full bg-gray-300 overflow-hidden shrink-0">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($product->user->name) }}&background=random" alt="{{ $product->user->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <a href="{{ route('users.show', $product->user) }}" class="truncate max-w-[90px] hover:text-[#1d3557] hover:underline">{{ $product->user->name }}</a>
                                </div>
                                <span>• {{ $product->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full bg-white border border-gray-100 rounded-3xl py-16 px-6 text-center shadow-sm">
                        <i class="bi bi-search text-4xl text-gray-300"></i>
                        <h2 class="text-xl font-bold text-gray-900 mt-4">No encontramos productos</h2>
                        <p class="text-sm text-gray-400 mt-2">Prueba cambiando o limpiando los filtros seleccionados.</p>
                    </div>
                @endforelse
            </section>

            @if($products->hasPages())
                <div class="w-full max-w-full mt-8 pb-4 overflow-x-auto flex justify-center">
                    {{ $products->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </section>
</x-sidebar-layout>
