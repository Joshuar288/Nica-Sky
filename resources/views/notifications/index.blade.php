<x-sidebar-layout>
    <x-slot:title>Notificaciones - NicaSky</x-slot:title>

    <section class="max-w-4xl mx-auto py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Notificaciones</h1>
            <p class="text-sm text-gray-400 mt-1">Aquí encontrarás las compras realizadas a tus publicaciones.</p>
        </div>

        @forelse($notifications as $notification)
            @php($data = $notification->data)
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
                    </div>
                </div>
            </article>
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
