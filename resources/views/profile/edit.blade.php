<x-sidebar-layout>
    <x-slot:title>Editar perfil - NicaSky</x-slot:title>

    <section class="max-w-5xl mx-auto py-6">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Editar perfil</h1>
                <p class="text-sm text-gray-400 mt-1">Administra tus datos personales y la seguridad de tu cuenta.</p>
            </div>
            <a href="{{ route('myprofile.show') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#0b132a] transition">
                <i class="bi bi-arrow-left"></i>Volver a mi perfil
            </a>
        </div>

        <div class="space-y-6">
            <div class="p-6 sm:p-8 bg-white border border-gray-100 shadow-sm rounded-3xl">
                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white border border-gray-100 shadow-sm rounded-3xl">
                <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white border border-red-100 shadow-sm rounded-3xl">
                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </section>
</x-sidebar-layout>
