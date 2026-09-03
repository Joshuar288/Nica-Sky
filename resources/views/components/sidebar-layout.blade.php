<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'NicaSky' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/nicastyle.css'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-gray-50 font-sans flex h-screen overflow-hidden">

    <!-- Sidebar Fijo a la Izquierda -->
    <aside class="w-64 bg-[#0b132a] text-white flex flex-col justify-between p-5 min-h-screen flex-shrink-0 sticky top-0 h-screen">
        <div>
            <!-- Logo -->
            <div class="flex justify-center -mt-5 mb-2">
                <a href="{{ route('home') }}" class="flex items-center justify-center" aria-label="Ir al inicio">
                    <img src="{{ asset('images/Imagotipo_NicaSky.svg') }}" alt="NicaSky Logo" class="block w-44 h-auto object-contain">
                </a>
            </div>

            <!-- Menú de Navegación -->
            <nav class="space-y-1.5">
                <a href="{{ route('home') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition {{ request()->routeIs('home') ? 'bg-[#1e2942] text-white' : 'text-gray-400 hover:text-white hover:bg-[#162038]' }}">
                    <i class="bi bi-house-door text-base"></i>
                    <span>Inicio</span>
                </a>
                <a href="{{ route('product.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:text-white hover:bg-[#162038] font-medium text-sm transition {{ request()->routeIs('product.index') ? 'bg-[#1e2942] text-white' : 'text-gray-400 hover:text-white hover:bg-[#162038]' }}">
                    <i class="bi bi-grid text-base"></i>
                    <span>Productos</span>
                </a>
                @if(!auth()->user()->isAuditor())
                    <a href="{{route('myprofile.show')}}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400 hover:text-white hover:bg-[#162038] font-medium text-sm transition{{ request()->routeIs('myprofile.show') ? 'bg-[#1e2942] text-white' : 'text-gray-400 hover:text-white hover:bg-[#162038]' }}" >
                        <i class="bi bi-bar-chart text-base"></i>
                        <span>Mi Perfil</span>
                    </a>
                    <a href="{{ route('premium.show') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition {{ request()->routeIs('premium.*') ? 'bg-[#1e2942] text-white' : 'text-gray-400 hover:text-white hover:bg-[#162038]' }}">
                        <i class="bi bi-gem text-base"></i>
                        <span>Plan Premium</span>
                    </a>
                @endif
                @if(auth()->user()->canAudit())
                    <a href="{{ route('auditor.shipments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-sm transition {{ request()->routeIs('auditor.*') ? 'bg-[#1e2942] text-white' : 'text-gray-400 hover:text-white hover:bg-[#162038]' }}">
                        <i class="bi bi-shield-check text-base"></i>
                        <span>Verificar envíos</span>
                    </a>
                @endif
            </nav>
        </div>

        <!-- Botón de Sesión (Login / Logout) -->
        <div class="pt-4 border-t border-gray-800">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#1d3557] hover:bg-[#25416b] text-white rounded-2xl text-sm font-semibold transition">
                        <i class="bi bi-box-arrow-right"></i>
                        Cerrar sesión
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#25416b] hover:bg-[#1d3557] text-white rounded-2xl text-sm font-semibold transition">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Iniciar sesión
                </a>
            @endauth
        </div>
    </aside>

    <!-- Contenido Dinámico de cada Vista -->
    <main class="flex-1 px-8 my-5 h-full overflow-y-auto bg-[#f8f8f8]">
        <!-- Header Superior Común -->
        <header class="flex justify-end items-center gap-3 rounded-full p-2 mb-1 mt-0 sticky top-0 bg-[#ffffff] z-10">
            @if(request()->routeIs('product.index'))
                <form action="{{ route('product.index') }}" method="GET" class="flex-1 max-w-xl mr-auto">
                    @foreach(request()->except(['q', 'page']) as $name => $value)
                        @if(!is_array($value))
                            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <div class="relative">
                        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="search" name="q" value="{{ request('q') }}" placeholder="Buscar producto, categoría o vendedor..." class="w-full pl-10 pr-24 py-2.5 rounded-full border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                        <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 px-4 py-2 bg-[#0b132a] hover:bg-[#162038] text-white rounded-full text-xs font-semibold transition">Buscar</button>
                    </div>
                </form>
            @endif
            <a href="{{ route('notifications.index') }}" class="relative w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 shadow-sm" aria-label="Ver notificaciones">
                <i class="bi bi-bell text-lg"></i>
                @php($unreadNotificationCount = auth()->user()->unreadNotifications()->count())
                @if($unreadNotificationCount > 0)
                    <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center">
                        {{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}
                    </span>
                @endif
            </a>
            @if(!auth()->user()->isAuditor())
                <a href="{{ route('cart.index') }}" class="relative w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 shadow-sm" aria-label="Ver carrito">
                    <i class="bi bi-bag text-lg"></i>
                    @php($cartCount = array_sum(session('cart', [])))
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-[#1d3557] text-white text-[10px] font-bold flex items-center justify-center">
                            {{ $cartCount > 99 ? '99+' : $cartCount }}
                        </span>
                    @endif
                </a>
            @endif
            <a href="{{ route('profile.edit') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 shadow-sm" aria-label="Editar perfil">
                <i class="bi bi-person-circle text-lg"></i>
            </a>
        </header>

        <!-- Aquí se renderizará el contenido propio de cada página -->
        {{ $slot }}
    </main>

</body>
</html>
