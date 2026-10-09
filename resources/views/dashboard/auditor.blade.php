<x-sidebar-layout>
    <x-slot:title>Panel de auditoría - NicaSky</x-slot:title>

    <section class="max-w-7xl mx-auto py-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-[#1d3557]">Control y verificación</span>
                <h1 class="text-3xl font-bold text-gray-900 mt-2">Panel de auditoría</h1>
                <p class="text-sm text-gray-400 mt-1">Supervisa las evidencias de envío presentadas por los vendedores.</p>
            </div>
            <a href="{{ route('auditor.shipments.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-[#0b132a] text-white text-xs font-semibold hover:bg-[#162038] transition"><i class="bi bi-shield-check"></i> Abrir verificaciones</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach([['Pendientes', $pendingCount, 'clock-history', 'bg-amber-50 text-amber-600'], ['Aprobadas', $approvedCount, 'check-circle', 'bg-green-50 text-green-600'], ['Rechazadas', $rejectedCount, 'x-circle', 'bg-red-50 text-red-600']] as [$label, $value, $icon, $color])
                <article class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm"><div class="flex items-center justify-between"><span class="text-sm text-gray-500">{{ $label }}</span><span class="w-10 h-10 rounded-xl {{ $color }} flex items-center justify-center"><i class="bi bi-{{ $icon }} text-lg"></i></span></div><p class="text-4xl font-bold text-gray-900 mt-5">{{ $value }}</p></article>
            @endforeach
        </div>

        <article class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mt-8">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between"><div><h2 class="font-bold text-gray-900">Actividad reciente</h2><p class="text-xs text-gray-400 mt-1">Últimas evidencias registradas.</p></div><a href="{{ route('auditor.shipments.index') }}" class="text-xs font-semibold text-[#1d3557]">Ver todas</a></div>
            <div class="divide-y divide-gray-100">
                @forelse($recentVerifications as $verification)
                    <div class="px-6 py-4 flex flex-wrap items-center justify-between gap-4"><div><p class="font-semibold text-sm text-gray-800">{{ $verification->seller?->name ?? 'Vendedor eliminado' }}</p><p class="text-xs text-gray-400">{{ $verification->created_at->diffForHumans() }}</p></div><span class="px-3 py-1 rounded-full text-xs font-semibold {{ $verification->status === 'approved' ? 'bg-green-50 text-green-700' : ($verification->status === 'rejected' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700') }}">{{ ['pending' => 'Pendiente', 'approved' => 'Aprobada', 'rejected' => 'Rechazada'][$verification->status] }}</span></div>
                @empty
                    <p class="p-8 text-sm text-gray-400">Todavía no hay verificaciones de envío.</p>
                @endforelse
            </div>
        </article>
    </section>
</x-sidebar-layout>
