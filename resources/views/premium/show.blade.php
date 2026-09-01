<x-sidebar-layout>
    <x-slot:title>Planes - NicaSky</x-slot:title>

    <section class="max-w-7xl mx-auto py-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-[#1d3557] text-xs font-semibold mb-4"><i class="bi bi-gem"></i>Planes NicaSky</span>
            <h1 class="text-4xl font-bold text-gray-900">Elige cuántos productos quieres destacar</h1>
            <p class="text-sm leading-7 text-gray-500 mt-3">Los productos recomendados obtienen mayor visibilidad en la página de inicio.</p>
        </div>

        @if(session('success'))
            <div class="max-w-3xl mx-auto mb-6 px-5 py-4 rounded-2xl bg-green-50 border border-green-100 text-sm font-semibold text-green-700">
                <i class="bi bi-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @error('plan')
            <div class="max-w-3xl mx-auto mb-6 px-5 py-4 rounded-2xl bg-red-50 border border-red-100 text-sm font-semibold text-red-700">{{ $message }}</div>
        @enderror

        @php
            $plans = [
                ['key' => 'free', 'name' => 'Gratuito', 'price' => 'C$ 0', 'limit' => 'Sin productos recomendados', 'limit2' => 'Sin límite de publicaciones', 'limit3' => 'Insignia Premium', 'limit4' => 'Publicidad no Intrusiva', 'rank' => 0],
                ['key' => 'pro_1', 'name' => 'Plan plus', 'price' => 'C$ 199', 'limit' => 'Hasta 5 productos recomendados', 'limit2' => 'Prioridades en Busquedas',  'limit3' => 'Insignia Premium', 'limit4' => 'Sin publicidad', 'rank' => 1],
                ['key' => 'pro_2', 'name' => 'Plan Pro', 'price' => 'C$ 399', 'limit' => 'Hasta 15 productos recomendados', 'limit2' => 'Soporte prioritario',  'limit3' => 'Personalización avanzada en tienda Digital', 'limit4' => 'Todos los beneficios de planes anteriores', 'rank' => 2],
                ['key' => 'pro_3', 'name' => 'Plan Nica', 'price' => 'C$ 699', 'limit' => 'Todos tus productos recomendados', 'limit2' => 'Acceso anticipado a nuevas funciones',  'limit3' => 'Destacar Perfil',  'limit4' => 'Todos los beneficios de planes anteriores', 'limit4', 'rank' => 3],
            ];
            $ranks = ['free' => 0, 'pro_1' => 1, 'pro_2' => 2, 'pro_3' => 3];
            $currentRank = $ranks[$user->plan] ?? 0;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            @foreach($plans as $plan)
                <article class="relative bg-white rounded-3xl border {{ $user->plan === $plan['key'] ? 'border-[#1d3557] ring-2 ring-[#1d3557]/10' : 'border-gray-100' }} p-6 shadow-sm flex flex-col">
                    @if($user->plan === $plan['key'])
                        <span class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full bg-[#1d3557] text-white text-[10px] font-bold">PLAN ACTUAL</span>
                    @endif

                    <h2 class="text-xl font-bold text-gray-900">{{ $plan['name'] }}</h2>
                    <p class="text-3xl font-bold text-[#1d3557] mt-4">{{ $plan['price'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Pago mensual</p>

                    <ul class="space-y-3 my-7 text-sm text-gray-600 flex-1">
                        <li class="flex gap-2"><i class="bi bi-check-circle-fill text-green-500"></i>{{ $plan['limit'] }}</li>
                        <li class="flex gap-2"><i class="bi bi-check-circle-fill text-green-500"></i>{{ $plan['limit2'] }}</li>
                        @if($plan['key'] !== 'free')
                            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-green-500"></i>{{ $plan['limit3'] }}</li>
                            <li class="flex gap-2"><i class="bi bi-check-circle-fill text-green-500"></i>{{ $plan['limit4'] }}</li>
                        @else
                            <li class="flex gap-2"><i class="bi bi-x-circle-fill text-gray-300"></i>{{ $plan['limit3'] }}</li>
                            <li class="flex gap-2"><i class="bi bi-x-circle-fill text-gray-300"></i>{{ $plan['limit4'] }}</li>
                        @endif
                    </ul>

                    @if($user->plan === $plan['key'])
                        <div class="w-full py-3 rounded-full bg-gray-100 text-center text-xs font-semibold text-gray-500">Activo</div>
                    @elseif($plan['rank'] < $currentRank || $plan['key'] === 'free')
                        <div class="w-full py-3 rounded-full bg-gray-50 text-center text-xs font-semibold text-gray-300">No disponible</div>
                    @else
                        <a href="{{ route('premium.checkout', $plan['key']) }}" class="block w-full py-3 rounded-full bg-[#0b132a] hover:bg-[#162038] text-white text-center text-xs font-semibold transition">Elegir {{ $plan['name'] }}</a>
                    @endif
                </article>
            @endforeach
        </div>

    </section>
</x-sidebar-layout>
