<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Información del perfil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Modifica tus datos personales y la información de tu negocio.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="phone" value="Teléfono" />
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $user->phone)" required autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="name_bussines" value="Nombre del negocio" />
            <x-text-input id="name_bussines" name="name_bussines" type="text" class="mt-1 block w-full" :value="old('name_bussines', $user->name_bussines)" autocomplete="organization" />
            <x-input-error class="mt-2" :messages="$errors->get('name_bussines')" />
        </div>

        <div>
            <x-input-label for="description" value="Descripción personal o de la tienda" />
            <textarea id="description" name="description" rows="4" maxlength="1000" placeholder="Cuenta qué ofreces, qué hace especial a tu tienda o agrega información sobre ti..." class="mt-1 block w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a] resize-none">{{ old('description', $user->description) }}</textarea>
            <div class="flex items-start justify-between gap-4 mt-1">
                <x-input-error :messages="$errors->get('description')" />
                <span class="ml-auto text-[10px] text-gray-400">Máximo 1000 caracteres</span>
            </div>
        </div>

        <div>
            <x-input-label for="city_id" value="Ciudad" />
            <select id="city_id" name="city_id" required class="mt-1 block w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                @foreach($cities->groupBy('name_departament') as $department => $departmentCities)
                    <optgroup label="{{ $department }}">
                        @foreach($departmentCities as $city)
                            <option value="{{ $city->id }}" @selected((int) old('city_id', $user->city_id) === $city->id)>{{ $city->name_city }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('city_id')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Guardar cambios</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
