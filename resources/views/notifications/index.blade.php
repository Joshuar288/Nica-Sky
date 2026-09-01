<x-sidebar-layout>
    <x-slot:title>Notificaciones - NicaSky</x-slot:title>

    <section class="max-w-4xl mx-auto py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Notificaciones</h1>
            <p class="text-sm text-gray-400 mt-1">Aquí encontrarás las compras realizadas a tus publicaciones.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100 text-sm font-semibold text-green-700">{{ session('success') }}</div>
        @endif

        @forelse($notifications as $notification)
            @php($data = $notification->data)
            @if(($data['kind'] ?? null) === 'shipment_submitted')
                <article class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm mb-5 flex items-start gap-4">
                    <div class="w-11 h-11 shrink-0 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center"><i class="bi bi-shield-check text-xl"></i></div>
                    <div class="flex-1">
                        <h2 class="font-bold text-gray-900">{{ $data['title'] }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $data['seller_name'] }} envió un comprobante para revisión.</p>
                        <a href="{{ route('auditor.shipments.index') }}" class="inline-flex mt-3 text-sm font-semibold text-[#1d3557] hover:underline">Abrir bandeja de auditoría</a>
                    </div>
                </article>
            @elseif(($data['kind'] ?? null) === 'shipment_reviewed')
                <article class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm mb-5 flex items-start gap-4">
                    <div class="w-11 h-11 shrink-0 rounded-full {{ $data['status'] === 'approved' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} flex items-center justify-center"><i class="bi bi-clipboard-check text-xl"></i></div>
                    <div><h2 class="font-bold text-gray-900">{{ $data['title'] }}</h2>@if($data['review_notes'])<p class="text-sm text-gray-500 mt-2">{{ $data['review_notes'] }}</p>@endif</div>
                </article>
            @else
            <article class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm mb-5">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 shrink-0 rounded-full bg-green-50 text-green-600 flex items-center justify-center">
                        <i class="bi bi-bag-check text-xl"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-start justify-between gap-2 mb-4">
                            <div>
                                <h2 class="font-bold text-gray-900">{{ $data['title'] }}</h2>
                                <p class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">{{ $data['payment']['status'] }}</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-5">
                            <div class="rounded-xl bg-gray-50 p-4">
                                <p class="text-xs text-gray-400 mb-1">Comprador</p>
                                <p class="font-semibold text-gray-800">{{ $data['buyer']['name'] }}</p>
                                <p class="text-gray-500">{{ $data['buyer']['email'] }}</p>
                                <p class="text-gray-500">{{ $data['buyer']['phone'] }}</p>
                            </div>
                            <div class="rounded-xl bg-gray-50 p-4">
                                <p class="text-xs text-gray-400 mb-1">Entrega y pago</p>
                                <p class="font-semibold text-gray-800">{{ $data['delivery_address'] }}</p>
                                <p class="text-gray-500 mt-1">{{ $data['payment']['method'] }}</p>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4">
                            @foreach($data['items'] as $item)
                                <div class="flex items-center justify-between gap-4 py-2 text-sm">
                                    <a href="{{ route('product.show', $item['product_id']) }}" class="font-semibold text-gray-700 hover:text-[#1d3557]">
                                        {{ $item['title'] }} <span class="font-normal text-gray-400">× {{ $item['quantity'] }}</span>
                                    </a>
                                    <span class="text-gray-600">C$ {{ number_format($item['subtotal'], 2) }}</span>
                                </div>
                            @endforeach
                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100 font-bold">
                                <span>Total recibido</span>
                                <span class="text-[#1d3557]">C$ {{ number_format($data['total'], 2) }}</span>
                            </div>
                        </div>

                        @php($verification = $verifications->get($notification->id))
                        <div class="mt-5 pt-5 border-t border-gray-100">
                            @if($verification)
                                <div class="flex flex-wrap items-center justify-between gap-3 p-4 rounded-xl {{ $verification->status === 'approved' ? 'bg-green-50 text-green-700' : ($verification->status === 'rejected' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700') }}">
                                    <span class="text-sm font-semibold">Evidencia de envío: {{ ['pending' => 'pendiente de revisión', 'approved' => 'aprobada', 'rejected' => 'rechazada'][$verification->status] }}</span>
                                    <a href="{{ route('shipments.evidence', $verification) }}" target="_blank" class="text-xs font-semibold underline">Ver comprobante</a>
                                </div>
                            @else
                                <details class="group">
                                    <summary class="cursor-pointer inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#0b132a] text-white text-xs font-semibold"><i class="bi bi-truck"></i> Confirmar envío</summary>
                                    <form action="{{ route('shipments.store', $notification->id) }}" method="POST" enctype="multipart/form-data" class="mt-4 grid sm:grid-cols-2 gap-4 p-5 rounded-2xl bg-gray-50 border border-gray-100">
                                        @csrf
                                        <div><label class="block text-xs font-semibold text-gray-600 mb-2">Número de seguimiento</label><input name="tracking_number" maxlength="100" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs" placeholder="Opcional"></div>
                                        <div><label class="block text-xs font-semibold text-gray-600 mb-2">Evidencia del envío</label><input name="evidence" type="file" accept="image/jpeg,image/png,image/webp,application/pdf" required class="w-full text-xs text-gray-500 file:mr-3 file:px-3 file:py-2 file:rounded-lg file:border-0 file:bg-white"></div>
                                        <div class="sm:col-span-2"><label class="block text-xs font-semibold text-gray-600 mb-2">Notas</label><textarea name="seller_notes" rows="2" maxlength="1000" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs" placeholder="Información adicional para el auditor"></textarea></div>
                                        <button class="sm:col-span-2 justify-self-start px-5 py-2.5 rounded-full bg-[#1d3557] text-white text-xs font-semibold">Enviar a verificación</button>
                                    </form>
                                </details>
                            @endif
                        </div>
                    </div>
                </div>
            </article>
            @endif
        @empty
            <div class="bg-white border border-gray-100 rounded-3xl py-20 px-6 text-center shadow-sm">
                <div class="w-16 h-16 mx-auto mb-5 rounded-full bg-gray-50 flex items-center justify-center">
                    <i class="bi bi-bell text-3xl text-gray-300"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">No tienes notificaciones</h2>
                <p class="text-sm text-gray-400">Las compras de tus productos aparecerán aquí.</p>
            </div>
        @endforelse

        <div class="mt-6">{{ $notifications->links() }}</div>
    </section>
</x-sidebar-layout>
