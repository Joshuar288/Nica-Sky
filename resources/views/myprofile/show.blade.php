<x-sidebar-layout>
    <x-slot:title>
        Mi Perfil - NicaSky
    </x-slot:title>

    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-8">

        <!-- Header del Perfil -->
        <div class="flex flex-col md:flex-row gap-8 items-start justify-between relative">

            <!-- Columna Izquierda: Foto y Datos Contacto -->
            <div class="flex gap-6 items-start">
                <div class="w-32 h-32 rounded-full overflow-hidden flex-shrink-0 border-2 border-gray-100 shadow-sm bg-gray-50 flex items-center justify-center">
                    <!-- Generador de avatar dinamico con el nombre del usuario -->
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name_bussines ?? $user->name) }}&background=0b132a&color=fff&size=128"
                         alt="{{ $user->name }}"
                         class="w-full h-full object-cover">
                </div>

                <div class="space-y-2 pt-1">
                    <!-- Muestra el nombre del negocio si existe, si no, el nombre de usuario -->
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ $user->name_bussines ?? $user->name }}
                    </h1>

                    <div class="space-y-1.5 text-xs text-gray-500 font-medium">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-person text-gray-400 text-sm"></i>
                            <span>{{ $user->name }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-geo-alt text-gray-400 text-sm"></i>
                            <span>{{ $user->city->name_departament ?? 'Ubicacion no especificada' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-telephone text-gray-400 text-sm"></i>
                            <span>{{ $user->phone }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-envelope text-gray-400 text-sm"></i>
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Boton Editar -->
            <div class="flex-1 max-w-2xl space-y-4">
                <div class="flex justify-end">
                    <a href="{{ route('profile.edit') }}" class="px-5 py-2 bg-[#0b132a] hover:bg-[#162038] text-white rounded-full text-xs font-semibold flex items-center gap-2 transition shadow-sm">
                        <i class="bi bi-pencil-fill text-[10px]"></i>
                        <span>Editar Perfil</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-6">
            <h2 class="text-sm font-bold text-gray-900 mb-2">Acerca de {{ $user->name_bussines ?? $user->name }}</h2>
            @if($user->description)
                <p class="text-sm leading-7 text-gray-500 whitespace-pre-line">{{ $user->description }}</p>
            @else
                <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl bg-gray-50 border border-dashed border-gray-200 p-4">
                    <p class="text-sm text-gray-400">Añade una descripción para que los visitantes conozcan mejor tu tienda.</p>
                    <a href="{{ route('profile.edit') }}" class="shrink-0 text-xs font-semibold text-[#1d3557] hover:underline">Añadir descripción</a>
                </div>
            @endif
        </div>

        <div class="flex justify-center">
            <a href="{{ route('product.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#0b132a] hover:bg-[#162038] text-white rounded-full text-xs font-semibold transition shadow-sm">
                <i class="bi bi-plus-lg text-sm"></i>
                <span>Crear publicacion</span>
            </a>
        </div>

        <!-- Grilla Dinamica del Catalogo -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-2">
            @forelse($user->products as $product)
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between relative group hover:shadow-md transition">
                    <a href="{{ route('product.edit', $product) }}"
                       class="absolute top-6 right-6 z-20 inline-flex h-8 items-center gap-1.5 rounded-full bg-white px-3 text-[11px] font-semibold text-[#0b132a] shadow-md transition hover:bg-[#0b132a] hover:text-white"
                       aria-label="Modificar {{ $product->title }}">
                        <i class="bi bi-pencil-fill text-[10px]"></i>
                        <span>Modificar</span>
                    </a>
                    <!-- Boton Carrito -->
                    <button class="absolute top-6 left-6 z-10 w-8 h-8 bg-[#0b132a] text-white rounded-full flex items-center justify-center shadow-md hover:scale-105 transition">
                        <i class="bi bi-cart text-xs"></i>
                    </button>

                    <!-- Imagen del Producto -->
                    <a href="{{ route('product.show', $product) }}" class="h-44 rounded-xl overflow-hidden mb-4 bg-gray-50 flex items-center justify-center relative" aria-label="Ver detalles de {{ $product->title }}">
                        @if($product->images->isNotEmpty())
                            <img src="{{ $product->images->first()->url }}"
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
                        <div class="mb-3">
                            @if($product->is_recommended)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-bold text-amber-700 ring-1 ring-inset ring-amber-200">
                                    <i class="bi bi-star-fill"></i>
                                    Visibilidad prioritaria
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-50 px-2.5 py-1 text-[10px] font-semibold text-gray-500 ring-1 ring-inset ring-gray-200">
                                    <i class="bi bi-eye"></i>
                                    Visibilidad normal
                                </span>
                            @endif
                        </div>

                        <div class="flex justify-between items-center mb-1">
                            <h3 class="min-w-0 flex-1 font-bold text-gray-900 text-sm truncate" title="{{ $product->title }}">{{ $product->title }}</h3>
                            <span class="shrink-0 font-bold text-[#1d3557] text-sm">C$ {{ number_format($product->price, 2) }}</span>
                        </div>

                        <p class="text-xs text-gray-400 line-clamp-2 mb-4">{{ $product->description }}</p>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-400">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full bg-gray-300 overflow-hidden shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="w-full h-full object-cover">
                                </div>
                                <span class="truncate max-w-[90px]">{{ $user->name }}</span>
                            </div>
                            <span>• {{ $product->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Estado vacio -->
                <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-gray-50/50 rounded-3xl border border-dashed border-gray-200">
                    <i class="bi bi-box-seam text-4xl text-gray-300 mb-3"></i>
                    <h4 class="text-sm font-bold text-gray-700">Aun no tienes publicaciones</h4>
                    <p class="text-xs text-gray-400 mt-1 mb-4">Empieza a vender publicando tus productos en la plataforma.</p>
                    <a href="{{ route('product.create') }}" class="px-5 py-2.5 bg-[#0b132a] text-white rounded-full text-xs font-semibold hover:bg-[#162038] transition">
                        Crear mi primera publicacion
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</x-sidebar-layout>
