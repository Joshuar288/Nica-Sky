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
                            <span>{{ $user->city->name ?? 'Ubicacion no especificada' }}</span>
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

        <!-- Redes Sociales -->
        <div class="flex items-center gap-4 pt-2 border-t border-gray-100 text-xs">
            <span class="font-bold text-gray-700">Redes sociales:</span>
            <div class="flex items-center gap-3 font-medium text-[#1d3557]">
                <a href="#" class="flex items-center gap-1.5 hover:underline">
                    <i class="bi bi-instagram text-sm"></i>
                    <span>Instagram</span>
                </a>
                <a href="#" class="flex items-center gap-1.5 hover:underline">
                    <i class="bi bi-twitter-x text-sm"></i>
                    <span>Twitter/X</span>
                </a>
                <a href="#" class="flex items-center gap-1.5 hover:underline">
                    <i class="bi bi-linkedin text-sm"></i>
                    <span>Linkedin</span>
                </a>
            </div>
        </div>

        <!-- Pestañas de Navegacion y Boton Crear Publicacion -->
        <div class="flex flex-col sm:flex-row items-center justify-between border-b border-gray-100 gap-4 pt-4">
            <div class="flex gap-8">
                <button class="pb-3 text-2xl font-bold text-gray-900 border-b-2 border-[#1d3557]">
                    Catalogo
                </button>
                <button class="pb-3 text-2xl font-bold text-gray-400 hover:text-gray-600 transition">
                    Inventario
                </button>
                <button class="pb-3 text-2xl font-bold text-gray-400 hover:text-gray-600 transition">
                    Salidas
                </button>
                <button class="pb-3 text-2xl font-bold text-gray-400 hover:text-gray-600 transition">
                    Reseñas
                </button>
            </div>

            <a href="{{ route('product.create') }}" class="px-5 py-2.5 bg-[#0b132a] hover:bg-[#162038] text-white rounded-full text-xs font-semibold flex items-center gap-2 transition shadow-sm mb-2">
                <i class="bi bi-plus-lg text-sm"></i>
                <span>Crear publicacion</span>
            </a>
        </div>

        <!-- Grilla Dinamica del Catalogo -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-2">
            @forelse($user->products as $product)
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
                    <a href="{{ route('products.create') }}" class="px-5 py-2.5 bg-[#0b132a] text-white rounded-full text-xs font-semibold hover:bg-[#162038] transition">
                        Crear mi primera publicacion
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</x-sidebar-layout>