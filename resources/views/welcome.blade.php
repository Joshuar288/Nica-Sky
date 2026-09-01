<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="NicaSky conecta compradores, emprendedores y proveedores de Nicaragua en un solo marketplace.">
    <title>NicaSky - Conectando emprendedores, compradores y proveedores</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <header x-data="{ menuOpen: false }" class="w-full bg-white/95 backdrop-blur border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="#inicio" class="flex items-center" aria-label="Ir al inicio">
                <img src="{{ asset('images/Imagotipo_NicaSky.svg') }}" alt="NicaSky" class="h-16 w-auto">
            </a>

            <nav class="hidden lg:flex items-center gap-7 text-sm font-semibold text-gray-600" aria-label="Navegación principal">
                <a href="#explorar" class="hover:text-blue-600 transition">Explorar productos</a>
                <a href="#como-funciona" class="hover:text-blue-600 transition">¿Cómo funciona?</a>
                <a href="#emprendedores" class="hover:text-blue-600 transition">Para emprendedores</a>
                <a href="#proveedores" class="hover:text-blue-600 transition">Proveedores</a>
                <a href="#planes" class="hover:text-blue-600 transition">Planes</a>
            </nav>

            <div class="hidden sm:flex items-center gap-2">
                @auth
                    <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-bold text-gray-700 hover:text-blue-600">Mi cuenta</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-blue-600">Ingresar</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition">Unirse a NicaSky</a>
                @endauth
            </div>

            <button type="button" @click="menuOpen = !menuOpen" class="lg:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100" :aria-expanded="menuOpen" aria-controls="mobile-menu" aria-label="Abrir menú">
                <i data-lucide="menu" class="w-6 h-6" x-show="!menuOpen"></i>
                <i data-lucide="x" class="w-6 h-6" x-show="menuOpen" x-cloak></i>
            </button>
        </div>

        <div id="mobile-menu" x-show="menuOpen" x-cloak @click.outside="menuOpen = false" class="lg:hidden border-t border-gray-100 bg-white px-4 py-4 shadow-lg">
            <nav class="flex flex-col gap-1 text-sm font-semibold text-gray-700">
                <a @click="menuOpen = false" href="#explorar" class="px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600">Explorar productos</a>
                <a @click="menuOpen = false" href="#como-funciona" class="px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600">¿Cómo funciona?</a>
                <a @click="menuOpen = false" href="#emprendedores" class="px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600">Para emprendedores</a>
                <a @click="menuOpen = false" href="#proveedores" class="px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600">Proveedores</a>
                <a @click="menuOpen = false" href="#planes" class="px-4 py-3 rounded-lg hover:bg-blue-50 hover:text-blue-600">Planes</a>
            </nav>
            <div class="sm:hidden grid grid-cols-2 gap-2 mt-4 pt-4 border-t border-gray-100">
                @auth
                    <a href="{{ route('home') }}" class="col-span-2 px-4 py-3 text-center text-sm font-semibold text-white bg-blue-600 rounded-xl">Mi cuenta</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-3 text-center text-sm font-semibold border border-gray-200 rounded-xl">Ingresar</a>
                    <a href="{{ route('register') }}" class="px-4 py-3 text-center text-sm font-semibold text-white bg-blue-600 rounded-xl">Registrarse</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        <section id="inicio" class="scroll-mt-20 bg-gradient-to-b from-blue-50/70 to-transparent py-16 lg:py-24">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
                <span class="inline-flex px-4 py-1.5 bg-blue-100 text-blue-800 font-semibold text-xs tracking-wide uppercase rounded-full">El mercado digital de Nicaragua</span>
                <h1 class="text-4xl sm:text-6xl font-black text-gray-900 tracking-tight leading-tight">El punto de encuentro para <span class="text-blue-600">comprar, vender y conectar</span></h1>
                <p class="text-lg sm:text-xl text-gray-600">NicaSky impulsa el crecimiento de pequeñas y medianas empresas conectando emprendedores, compradores y proveedores en un solo lugar.</p>
                <div class="flex flex-wrap justify-center gap-4 pt-2 text-sm font-semibold">
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition">Comenzar a vender</a>
                    <a href="#explorar" class="px-6 py-3 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition">Conocer el marketplace</a>
                </div>
            </div>
        </section>

        <section id="explorar" class="scroll-mt-20 py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-blue-600 text-sm font-bold uppercase tracking-wider">Explorar productos</span>
                    <h2 class="mt-3 text-3xl sm:text-4xl font-black text-gray-900">Encuentra productos de negocios nicaragüenses</h2>
                    <p class="mt-5 text-gray-600 leading-relaxed">Descubre publicaciones por nombre, categoría, ubicación o vendedor. Compara alternativas, revisa la información del negocio y guarda tus productos en el carrito.</p>
                    <div class="mt-7">
                        @auth
                            <a href="{{ route('product.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition">Ver productos <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition">Crear cuenta para explorar <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
                        @endauth
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach ([['search', 'Búsqueda sencilla', 'Busca por producto, categoría o vendedor.'], ['sliders-horizontal', 'Filtros útiles', 'Filtra por precio, ciudad y departamento.'], ['store', 'Negocios locales', 'Conoce el perfil y catálogo de cada vendedor.'], ['shopping-cart', 'Compra organizada', 'Reúne tus productos antes de confirmar.']] as [$icon, $title, $description])
                        <article class="p-6 rounded-2xl bg-gray-50 border border-gray-100">
                            <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center"><i data-lucide="{{ $icon }}" class="w-5 h-5"></i></div>
                            <h3 class="mt-4 font-bold text-gray-900">{{ $title }}</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ $description }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="como-funciona" class="scroll-mt-20 py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center">
                    <span class="text-blue-600 text-sm font-bold uppercase tracking-wider">¿Cómo funciona?</span>
                    <h2 class="mt-3 text-3xl sm:text-4xl font-black text-gray-900">De la publicación a la compra</h2>
                    <p class="mt-4 text-gray-600">NicaSky organiza el proceso para que compradores, emprendedores y proveedores puedan encontrarse y hacer negocios desde un solo lugar.</p>
                </div>

                <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ([
                        ['user-round-check', '01', 'Crea tu cuenta y perfil', 'Regístrate y completa la información personal o de tu negocio. Tu perfil público permite mostrar la descripción de la tienda y su catálogo.'],
                        ['package-plus', '02', 'Publica o explora', 'Crea publicaciones con imágenes, precio, categoría, estado y disponibilidad, o utiliza la búsqueda y los filtros para encontrar productos.'],
                        ['shopping-cart', '03', 'Prepara tu compra', 'Consulta la publicación y el perfil del vendedor. Después añade los productos que deseas al carrito antes de continuar al pago.'],
                        ['credit-card', '04', 'Confirma los datos', 'Indica la información de pago y la dirección de entrega.'],
                        ['bell-ring', '05', 'El vendedor recibe el pedido', 'Al confirmar la compra, el propietario de cada publicación recibe una notificación con el producto solicitado y los datos necesarios para la entrega.'],
                        ['sparkles', '06', 'Obtén mayor visibilidad', 'Los vendedores pueden seleccionar publicaciones recomendadas según los cupos incluidos en su plan: Plus, Pro o Nica.'],
                    ] as [$icon, $number, $title, $description])
                        <article class="group bg-white p-7 rounded-2xl border border-gray-100 shadow-sm hover:-translate-y-1 hover:shadow-md transition">
                            <div class="flex items-center justify-between">
                                <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
                                </div>
                                <span class="text-3xl font-black text-blue-100 group-hover:text-blue-200 transition">{{ $number }}</span>
                            </div>
                            <h3 class="mt-5 text-lg font-bold text-gray-900">{{ $title }}</h3>
                            <p class="mt-3 text-sm leading-relaxed text-gray-600">{{ $description }}</p>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8 p-6 sm:p-7 bg-blue-50 border border-blue-100 rounded-2xl flex flex-col sm:flex-row gap-5 items-start">
                    <div class="shrink-0 w-11 h-11 rounded-xl bg-blue-600 text-white flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Próxima etapa: pago protegido y envío</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600">NicaSky contempla retener temporalmente el dinero mientras el vendedor realiza el envío por un servicio como CargoTrans y solicitar evidencia del despacho. Si el envío no se completa en el plazo establecido, se contempla devolver el pago al comprador.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="emprendedores" class="scroll-mt-20 py-20 bg-[#0b132a] text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-cyan-400 text-sm font-bold uppercase tracking-wider">Para emprendedores</span>
                    <h2 class="mt-3 text-3xl sm:text-4xl font-black">Convierte tu negocio en un catálogo digital</h2>
                    <p class="mt-5 text-slate-300 leading-relaxed">Publica tus productos, presenta la historia de tu tienda y consigue mayor exposición con los planes de recomendaciones de NicaSky.</p>
                    <a href="{{ route('register') }}" class="mt-8 inline-flex items-center gap-2 px-6 py-3 bg-cyan-500 text-[#0b132a] font-bold rounded-xl hover:bg-cyan-400 transition">Publicar mis productos <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach ([['package-plus', 'Publicaciones', 'Crea fichas claras con imágenes, precio y disponibilidad.'], ['badge-check', 'Perfil público', 'Muestra tu descripción y todo el catálogo de tu negocio.'], ['bar-chart-3', 'Visibilidad', 'Conoce las visitas y destaca productos recomendados.'], ['bell', 'Notificaciones', 'Recibe información cuando alguien confirme una compra.']] as [$icon, $title, $description])
                        <article class="p-6 rounded-2xl bg-white/5 border border-white/10">
                            <i data-lucide="{{ $icon }}" class="w-6 h-6 text-cyan-400"></i>
                            <h3 class="mt-4 font-bold">{{ $title }}</h3>
                            <p class="mt-2 text-sm text-slate-300">{{ $description }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="proveedores" class="scroll-mt-20 py-20 bg-white">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="mx-auto w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center"><i data-lucide="truck" class="w-7 h-7"></i></div>
                <span class="mt-6 block text-emerald-600 text-sm font-bold uppercase tracking-wider">Proveedores</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-black text-gray-900">Llega a quienes necesitan tus insumos</h2>
                <p class="mt-5 text-gray-600 leading-relaxed">Presenta materias primas, herramientas o productos al por mayor y conecta con emprendimientos que buscan abastecerse dentro del país.</p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition">Registrarme como proveedor</a>
                    <a href="#como-funciona" class="px-6 py-3 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">Ver cómo funciona</a>
                </div>
            </div>
        </section>

        <section id="planes" class="scroll-mt-20 py-20 bg-gray-50">
            @php
                $landingPlans = [
                    ['name' => 'Gratuito', 'price' => 'C$ 0', 'benefits' => ['Sin productos recomendados', 'Sin límite de publicaciones', 'Insignia Premium', 'Publicidad no intrusiva'], 'free' => true],
                    ['name' => 'Plan plus', 'price' => 'C$ 199', 'benefits' => ['Hasta 5 productos recomendados', 'Prioridades en búsquedas', 'Insignia Premium', 'Sin publicidad'], 'free' => false],
                    ['name' => 'Plan Pro', 'price' => 'C$ 399', 'benefits' => ['Hasta 15 productos recomendados', 'Soporte prioritario', 'Personalización avanzada en tienda digital', 'Todos los beneficios de planes anteriores'], 'free' => false],
                    ['name' => 'Plan Nica', 'price' => 'C$ 699', 'benefits' => ['Todos tus productos recomendados', 'Acceso anticipado a nuevas funciones', 'Destacar perfil', 'Todos los beneficios de planes anteriores'], 'free' => false],
                ];
            @endphp

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-[#1d3557] text-xs font-semibold">
                        <i data-lucide="gem" class="w-4 h-4"></i> Planes NicaSky
                    </span>
                    <h2 class="mt-4 text-3xl sm:text-4xl font-black text-gray-900">Elige cuántos productos quieres destacar</h2>
                    <p class="mt-4 text-gray-600">Los productos recomendados obtienen mayor visibilidad en la página de inicio.</p>
                </div>

                <div class="mt-12 grid md:grid-cols-2 xl:grid-cols-4 gap-6">
                    @foreach ($landingPlans as $plan)
                        <article class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm flex flex-col hover:-translate-y-1 hover:shadow-md transition">
                            <h3 class="text-xl font-bold text-gray-900">{{ $plan['name'] }}</h3>
                            <p class="text-3xl font-bold text-[#1d3557] mt-4">{{ $plan['price'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">Pago mensual</p>

                            <ul class="space-y-3 my-7 text-sm text-gray-600 flex-1">
                                @foreach ($plan['benefits'] as $index => $benefit)
                                    <li class="flex gap-2 items-start">
                                        @if ($plan['free'] && $index >= 2)
                                            <i data-lucide="x-circle" class="w-4 h-4 mt-0.5 shrink-0 text-gray-300"></i>
                                        @else
                                            <i data-lucide="check-circle" class="w-4 h-4 mt-0.5 shrink-0 text-green-500"></i>
                                        @endif
                                        <span>{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            @auth
                                <a href="{{ route('premium.show') }}" class="w-full py-3 rounded-full bg-[#0b132a] hover:bg-[#162038] text-white text-center text-xs font-semibold transition">Ver {{ $plan['name'] }}</a>
                            @else
                                <a href="{{ route('register') }}" class="w-full py-3 rounded-full bg-[#0b132a] hover:bg-[#162038] text-white text-center text-xs font-semibold transition">Elegir {{ $plan['name'] }}</a>
                            @endauth
                        </article>
                    @endforeach
                </div>

            </div>
        </section>

        <section class="py-16 bg-blue-600">
            <div class="max-w-4xl mx-auto px-4 text-center text-white">
                <h2 class="text-3xl font-black">¿Listo para formar parte de NicaSky?</h2>
                <p class="mt-3 text-blue-100">Únete al marketplace que impulsa el comercio y el emprendimiento nacional.</p>
                <a href="{{ route('register') }}" class="mt-7 inline-flex px-7 py-3 bg-white text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition">Crear una cuenta</a>
            </div>
        </section>
    </main>

    <footer class="bg-[#0b132a] py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row gap-4 items-center justify-between text-sm text-slate-400">
            <p>&copy; {{ date('Y') }} NicaSky Marketplace. Todos los derechos reservados.</p>
            <a href="#inicio" class="inline-flex items-center gap-2 hover:text-white transition">Volver arriba <i data-lucide="arrow-up" class="w-4 h-4"></i></a>
        </div>
    </footer>

    <script>document.addEventListener('DOMContentLoaded', () => window.lucide?.createIcons());</script>
</body>
</html>
