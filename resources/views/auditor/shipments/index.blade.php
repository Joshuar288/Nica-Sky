<x-sidebar-layout>
    <x-slot:title>Verificación de envíos - NicaSky</x-slot:title>

    <section class="max-w-6xl mx-auto py-6">
        <div class="mb-8">
            <span class="text-xs font-semibold uppercase tracking-wider text-[#1d3557]">Panel de auditoría</span>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">Verificación de envíos</h1>
            <p class="text-sm text-gray-400 mt-1">Revisa los comprobantes enviados por los vendedores.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100 text-sm font-semibold text-green-700">{{ session('success') }}</div>
        @endif

        <div class="space-y-5">
            @forelse($verifications as $verification)
                <article class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap justify-between gap-3">
                                <div>
                                    <h2 class="font-bold text-gray-900">Envío de {{ $verification->seller->name }}</h2>
                                    <p class="text-xs text-gray-400">Enviado {{ $verification->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $verification->status === 'approved' ? 'bg-green-50 text-green-700' : ($verification->status === 'rejected' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700') }}">
                                    {{ ['pending' => 'Pendiente', 'approved' => 'Aprobado', 'rejected' => 'Rechazado'][$verification->status] }}
                                </span>
                            </div>
                            <dl class="mt-5 grid sm:grid-cols-2 gap-4 text-sm">
                                <div><dt class="text-xs text-gray-400">Número de seguimiento</dt><dd class="font-semibold text-gray-700">{{ $verification->tracking_number ?: 'No indicado' }}</dd></div>
                                <div><dt class="text-xs text-gray-400">Auditor</dt><dd class="font-semibold text-gray-700">{{ $verification->auditor?->name ?? 'Sin asignar' }}</dd></div>
                            </dl>
                            @if($verification->seller_notes)<p class="mt-4 p-4 bg-gray-50 rounded-xl text-sm text-gray-600">{{ $verification->seller_notes }}</p>@endif
                            <a href="{{ route('shipments.evidence', $verification) }}" target="_blank" rel="noopener" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-[#1d3557] hover:underline"><i class="bi bi-paperclip"></i> Ver evidencia</a>
                        </div>

                        @if($verification->status === 'pending')
                            <form action="{{ route('auditor.shipments.review', $verification) }}" method="POST" class="lg:w-80 p-5 rounded-2xl bg-gray-50 border border-gray-100">
                                @csrf @method('PATCH')
                                <label class="block text-xs font-semibold text-gray-600 mb-2">Observaciones</label>
                                <textarea name="review_notes" rows="3" maxlength="1000" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]" placeholder="Obligatorias si rechazas"></textarea>
                                <div class="grid grid-cols-2 gap-2 mt-3">
                                    <button name="status" value="rejected" class="py-2.5 rounded-xl border border-red-200 text-xs font-semibold text-red-600 hover:bg-red-50">Rechazar</button>
                                    <button name="status" value="approved" class="py-2.5 rounded-xl bg-green-600 text-xs font-semibold text-white hover:bg-green-700">Aprobar</button>
                                </div>
                            </form>
                        @elseif($verification->review_notes)
                            <div class="lg:w-80 p-5 rounded-2xl bg-gray-50 text-sm text-gray-600"><p class="text-xs font-semibold text-gray-400 mb-2">Resultado de revisión</p>{{ $verification->review_notes }}</div>
                        @endif
                    </div>
                </article>
            @empty
                <div class="bg-white rounded-3xl border border-gray-100 py-16 text-center"><i class="bi bi-shield-check text-4xl text-gray-300"></i><h2 class="font-bold text-gray-700 mt-3">No hay evidencias pendientes</h2></div>
            @endforelse
        </div>
        <div class="mt-6">{{ $verifications->links() }}</div>
    </section>
</x-sidebar-layout>
