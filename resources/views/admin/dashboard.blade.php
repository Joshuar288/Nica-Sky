<x-sidebar-layout>
    <x-slot:title>Panel de administración - NicaSky</x-slot:title>

    <section class="max-w-7xl mx-auto py-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-[#1d3557]">Administración general</span>
                <h1 class="text-3xl font-bold text-gray-900 mt-2">Panel de administración</h1>
                <p class="text-sm text-gray-400 mt-1">Resumen de la actividad actual de NicaSky.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-white border border-gray-200 text-[#0b132a] text-xs font-semibold hover:bg-gray-50 transition"><i class="bi bi-box-seam"></i> Revisar publicaciones</a>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-white border border-gray-200 text-[#0b132a] text-xs font-semibold hover:bg-gray-50 transition"><i class="bi bi-people"></i> Gestionar usuarios</a>
                <a href="{{ route('auditor.shipments.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-[#0b132a] text-white text-xs font-semibold hover:bg-[#162038] transition"><i class="bi bi-shield-check"></i> Revisar envíos</a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
            @foreach([
                ['Usuarios', $totalUsers, 'people', 'bg-blue-50 text-blue-600'],
                ['Compradores y vendedores', $totalCustomers, 'person-check', 'bg-emerald-50 text-emerald-600'],
                ['Publicaciones', $totalProducts, 'box-seam', 'bg-violet-50 text-violet-600'],
                ['Recomendados', $recommendedProducts, 'stars', 'bg-amber-50 text-amber-600'],
                ['Envíos pendientes', $pendingShipments, 'truck', 'bg-rose-50 text-rose-600'],
            ] as [$label, $value, $icon, $color])
                <article class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <div class="flex items-center justify-between"><span class="text-xs text-gray-500">{{ $label }}</span><span class="w-9 h-9 rounded-xl {{ $color }} flex items-center justify-center"><i class="bi bi-{{ $icon }}"></i></span></div>
                    <p class="text-3xl font-bold text-gray-900 mt-4">{{ $value }}</p>
                </article>
            @endforeach
        </div>

        <div class="grid lg:grid-cols-2 gap-6 mt-8">
            <article class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between"><h2 class="font-bold text-gray-900">Usuarios recientes</h2><a href="{{ route('profile.edit') }}" class="text-xs font-semibold text-[#1d3557]">Mi perfil</a></div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentUsers as $user)
                        <div class="px-6 py-4 flex items-center justify-between gap-4"><div class="min-w-0"><p class="font-semibold text-sm text-gray-800 truncate">{{ $user->name }}</p><p class="text-xs text-gray-400 truncate">{{ $user->email }}</p></div><span class="shrink-0 px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 text-[10px] font-semibold">{{ $user->role->label() }}</span></div>
                    @empty
                        <p class="p-6 text-sm text-gray-400">No hay usuarios registrados.</p>
                    @endforelse
                </div>
            </article>

            <article class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between"><h2 class="font-bold text-gray-900">Publicaciones recientes</h2><a href="{{ route('product.index') }}" class="text-xs font-semibold text-[#1d3557]">Ver productos</a></div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentProducts as $product)
                        <div class="px-6 py-4 flex items-center justify-between gap-4"><div class="min-w-0"><p class="font-semibold text-sm text-gray-800 truncate">{{ $product->title }}</p><p class="text-xs text-gray-400 truncate">{{ $product->user?->name ?? 'Sin usuario' }}</p></div><span class="shrink-0 font-semibold text-sm text-[#1d3557]">C$ {{ number_format($product->price, 2) }}</span></div>
                    @empty
                        <p class="p-6 text-sm text-gray-400">No hay publicaciones registradas.</p>
                    @endforelse
                </div>
            </article>
        </div>
    </section>
</x-sidebar-layout>
