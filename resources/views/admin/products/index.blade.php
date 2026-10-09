<x-sidebar-layout>
    <x-slot:title>Revisar publicaciones - NicaSky</x-slot:title>

    <section class="max-w-7xl mx-auto py-6">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 mb-8">
            <div><span class="text-xs font-semibold uppercase tracking-wider text-[#1d3557]">Moderación</span><h1 class="text-3xl font-bold text-gray-900 mt-2">Revisar publicaciones</h1><p class="text-sm text-gray-400 mt-1">Aprueba, rechaza o elimina publicaciones de la plataforma.</p></div>
            <form method="GET" class="flex flex-wrap gap-2">
                <input name="q" value="{{ request('q') }}" placeholder="Buscar título o usuario" class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs">
                <select name="status" class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs"><option value="">Todos los estados</option><option value="approved" @selected(request('status') === 'approved')>Aprobadas</option><option value="rejected" @selected(request('status') === 'rejected')>Rechazadas</option><option value="pending" @selected(request('status') === 'pending')>Pendientes</option></select>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-[#0b132a] text-white text-xs font-semibold">Filtrar</button>
            </form>
        </div>

        @if(session('success'))<div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100 text-sm font-semibold text-green-700">{{ session('success') }}</div>@endif

        @php($moderationLabels = ['pending' => 'Pendiente', 'approved' => 'Aprobada', 'rejected' => 'Rechazada'])
        <div class="space-y-4">
            @forelse($products as $product)
                <article class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                    <div class="flex flex-col lg:flex-row gap-5 lg:items-center">
                        <div class="w-24 h-24 shrink-0 rounded-xl overflow-hidden bg-gray-50 flex items-center justify-center">
                            @if($product->images->isNotEmpty())<img src="{{ $product->images->first()->url }}" alt="{{ $product->title }}" class="w-full h-full object-cover">@else<i class="bi bi-image text-2xl text-gray-300"></i>@endif
                        </div>
                        <div class="min-w-0 flex-1"><div class="flex flex-wrap items-center gap-2"><h2 class="font-bold text-gray-900 truncate">{{ $product->title }}</h2><span class="px-2 py-1 rounded-full text-[10px] font-semibold {{ $product->moderation_status === 'rejected' ? 'bg-red-50 text-red-700' : ($product->moderation_status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700') }}">{{ $moderationLabels[$product->moderation_status] ?? 'Pendiente' }}</span></div><p class="text-sm text-gray-500 mt-1">{{ $product->user?->name ?? 'Usuario eliminado' }} · {{ $product->category?->name ?? 'Sin categoría' }}</p><p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $product->description }}</p>@if($product->moderation_notes)<p class="text-xs text-red-600 mt-2">Nota: {{ $product->moderation_notes }}</p>@endif</div>
                        <div class="flex flex-wrap gap-2 shrink-0"><a href="{{ route('product.show', $product) }}" class="px-4 py-2 rounded-full border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50">Ver</a><form action="{{ route('admin.products.moderate', $product) }}" method="POST" class="flex gap-2">@csrf @method('PATCH')<input type="hidden" name="moderation_status" value="approved"><button type="submit" class="px-4 py-2 rounded-full bg-green-600 text-white text-xs font-semibold hover:bg-green-700">Aprobar</button></form><details class="relative"><summary class="cursor-pointer list-none px-4 py-2 rounded-full bg-red-50 text-red-700 text-xs font-semibold hover:bg-red-100">Rechazar</summary><form action="{{ route('admin.products.moderate', $product) }}" method="POST" class="absolute right-0 top-11 z-20 w-64 p-4 bg-white border border-gray-100 rounded-2xl shadow-xl">@csrf @method('PATCH')<input type="hidden" name="moderation_status" value="rejected"><textarea name="moderation_notes" required maxlength="1000" rows="3" class="w-full rounded-xl border border-gray-200 text-xs" placeholder="Motivo del rechazo"></textarea><button type="submit" class="mt-2 w-full py-2 rounded-xl bg-red-600 text-white text-xs font-semibold">Confirmar rechazo</button></form></details><form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar esta publicación?')">@csrf @method('DELETE')<button type="submit" class="px-4 py-2 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold hover:bg-gray-200">Eliminar</button></form></div>
                    </div>
                </article>
            @empty
                <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center text-sm text-gray-400">No hay publicaciones para mostrar.</div>
            @endforelse
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    </section>
</x-sidebar-layout>
