<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NicaSky - Conectando emprendedores, compradores y proveedores</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Iconos de Lucide o FontAwesome via CDN (Opcional) -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <!-- Header / Navbar -->
    <header class="w-full bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <div class="flex items-center space-x-3">
                <a href="/" class="text-2xl font-black tracking-tight text-blue-600 flex items-center gap-2">
                    <span class="bg-blue-600 text-white p-2 rounded-xl text-lg font-extrabold">NS</span>
                    <span>Nica<span class="text-gray-900">Sky</span></span>
                </a>
            </div>

            <!-- Navegacion Central -->
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-gray-600">
                <a href="#explorar" class="hover:text-blue-600 transition">Explorar Productos</a>
                <a href="#como-funciona" class="hover:text-blue-600 transition">¿Como funciona?</a>
                <a href="#emprendedores" class="hover:text-blue-600 transition">Para Emprendedores</a>
                <a href="#proveedores" class="hover:text-blue-600 transition">Proveedores</a>
            </nav>

            <!-- Acciones de Usuario -->
            <div class="flex items-center space-x-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('home') }}" class="px-4 py-2 text-sm font-bold text-gray-700 hover:text-blue-600">Mi Cuenta</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600">Ingresar</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition">Unirse a NicaSky</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-blue-50/50 to-transparent py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl space-y-8">
            <span class="px-4 py-1.5 bg-blue-100 text-blue-800 font-semibold text-xs tracking-wide uppercase rounded-full">
                El mercado digital de Nicaragua
            </span>
            
            <h1 class="text-4xl sm:text-6xl font-black text-gray-900 tracking-tight leading-tight">
                El punto de encuentro para <span class="text-blue-600">comprar, vender y conectar</span>
            </h1>
            
            <p class="text-lg sm:text-xl text-gray-600 font-normal">
                NicaSky impulsa el crecimiento de pequeñas y medianas empresas conectando emprendedores, compradores y proveedores en un solo lugar.
            </p>

            <!-- Buscador Rapido -->
            <div class="pt-2 max-w-2xl mx-auto">
                <form action="#" method="GET" class="flex flex-col sm:flex-row gap-2 bg-white p-2 rounded-2xl shadow-lg border border-gray-100">
                    <input type="text" name="q" placeholder="¿Que producto, servicio o proveedor buscas hoy?" class="w-full px-4 py-3 text-sm rounded-xl focus:outline-none border-none text-gray-700">
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition flex items-center justify-center gap-2">
                        Buscar
                    </button>
                </form>
            </div>

            <!-- CTAs Secundarios -->
            <div class="flex flex-wrap justify-center gap-4 pt-4 text-sm font-semibold">
                <a href="{{ route('register') }}" class="px-6 py-3 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition">
                    Vender o Vender Insumos
                </a>
                <a href="#explorar" class="px-6 py-3 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                    Explorar Marketplace
                </a>
            </div>
        </div>
    </section>

    <!-- Perfiles de Uso (3 Columnas) -->
    <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Ecosistema NicaSky</h2>
            <p class="text-gray-600 mt-2">Diseñado para cada actor del comercio local</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Emprendedores -->
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6 font-bold text-xl">
                    🛍️
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Emprendedores</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Crea tu catalogo digital, promociona tus productos o servicios y llega a mas clientes sin complicaciones.
                </p>
            </div>

            <!-- Compradores -->
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-6 font-bold text-xl">
                    🛒
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Compradores</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Descubre ofertas locales, apoya el comercio nacional y contacta directamente con los vendedores de forma rapida.
                </p>
            </div>

            <!-- Proveedores -->
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-6 font-bold text-xl">
                    📦
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Proveedores</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Abastece a las PYMES conectando directamente con emprendedores que buscan materia prima o insumos al por mayor.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-10 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} NicaSky Marketplace. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>