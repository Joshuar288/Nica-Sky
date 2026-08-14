<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - NicaSky</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4 sm:p-6 font-sans">

    <!-- Tarjeta Principal -->
    <div class="w-full max-w-md bg-[#faf9f5] rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100/50 my-6">
        
        <!-- Encabezado de la Tarjeta -->
        <div class="flex items-center gap-3 pb-6 border-b border-gray-200/60 mb-8">
            <a href="home" class="flex items-center gap-2">
                <span class="bg-[#0f2137] text-white p-2 rounded-xl text-sm font-black">NS</span>
            </a>
            <h1 class="text-xl font-bold text-gray-900">Iniciar sesión</h1>
        </div>

        <!-- Formulario -->
        <div class="space-y-5">
            
            <!-- Estado de Sesión (Mensajes) -->
            @if (session('status'))
                <div class="p-3 bg-green-50 border border-green-200 text-green-700 text-xs rounded-xl">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Correo Electrónico -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           placeholder="Ingrese su correo electrónico" 
                           class="w-full px-4 py-3 bg-white rounded-xl border-none outline-none focus:ring-2 focus:ring-[#0f2137] text-sm text-gray-700 placeholder-gray-400 shadow-sm">
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-semibold text-gray-700">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:underline font-medium">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                           placeholder="Ingrese su contraseña" 
                           class="w-full px-4 py-3 bg-white rounded-xl border-none outline-none focus:ring-2 focus:ring-[#0f2137] text-sm text-gray-700 placeholder-gray-400 shadow-sm">
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recordarme -->
                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember" 
                               class="rounded border-gray-300 text-[#0f2137] shadow-sm focus:ring-[#0f2137] w-4 h-4">
                        <span class="ms-2 text-xs text-gray-600 font-medium">Recordar sesión</span>
                    </label>
                </div>

                <!-- Botón Iniciar Sesión -->
                <button type="submit" class="w-full py-3 bg-[#0f2137] hover:bg-[#162d4a] text-white font-medium rounded-full text-sm shadow transition duration-200 mt-2">
                    Ingresar
                </button>
            </form>

            <!-- Enlace a Registro -->
            <div class="text-center text-xs text-gray-500 font-medium pt-1">
                ¿No tienes una cuenta? <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Regístrate gratis</a>
            </div>

            <!-- Divisor 'O' -->
            <div class="relative my-6 flex items-center justify-center">
                <div class="w-full border-t border-gray-200"></div>
                <div class="absolute bg-[#faf9f5] px-3">
                    <span class="w-3.5 h-3.5 rounded-full border border-gray-400 block"></span>
                </div>
            </div>

            <!-- Botones Redes Sociales -->
            <div class="grid grid-cols-2 gap-4">
                <a href="#" class="w-full py-2.5 px-4 bg-white border border-gray-300 rounded-full text-xs font-semibold text-gray-700 hover:bg-gray-50 transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/><path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.11-6.72-4.96H1.29v3.15C3.26 21.3 7.31 24 12 24z"/><path fill="#FBBC05" d="M5.28 14.24c-.25-.72-.38-1.49-.38-2.24s.13-1.52.38-2.24V6.61H1.29C.47 8.24 0 10.06 0 12s.47 3.76 1.29 5.39l3.99-3.15z"/><path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.7 1.29 6.61l3.99 3.15c.95-2.85 3.6-4.96 6.72-4.96z"/></svg>
                    Google
                </a>
                <a href="#" class="w-full py-2.5 px-4 bg-white border border-gray-300 rounded-full text-xs font-semibold text-gray-700 hover:bg-gray-50 transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4 text-[#1877f2] fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </a>
            </div>

        </div>
    </div>

</body>
</html>