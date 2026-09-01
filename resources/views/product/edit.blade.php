<x-sidebar-layout>
    <x-slot:title>Modificar publicación - NicaSky</x-slot:title>

    <div class="max-w-5xl mx-auto bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-8">
        <div class="flex items-center justify-between border-b border-gray-100 pb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Modificar publicación</h1>
                <p class="text-xs text-gray-400 mt-1">Actualiza la información de tu producto.</p>
            </div>
            <a href="{{ route('myprofile.show') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full text-xs font-semibold flex items-center gap-2 transition">
                <i class="bi bi-arrow-left"></i>
                <span>Cancelar</span>
            </a>
        </div>

        <form action="{{ route('product.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-7 space-y-6">
                    <section class="space-y-4">
                        <h2 class="text-base font-bold text-gray-900 border-b border-gray-50 pb-2">Información del producto</h2>

                        <div>
                            <label for="title" class="block text-xs font-semibold text-gray-700 mb-1">Título de la publicación</label>
                            <input id="title" name="title" type="text" value="{{ old('title', $product->title) }}" required maxlength="255"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                            @error('title') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-semibold text-gray-700 mb-1">Descripción</label>
                            <textarea id="description" name="description" rows="4" required maxlength="1000"
                                      class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a] resize-none">{{ old('description', $product->description) }}</textarea>
                            @error('description') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-xs font-semibold text-gray-700 mb-1">Categoría</label>
                            <select id="category_id" name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                                @foreach($categories->groupBy('type_category') as $type => $group)
                                    <optgroup label="{{ $type }}">
                                        @foreach($group as $category)
                                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </section>

                    <section class="space-y-4">
                        <h2 class="text-base font-bold text-gray-900 border-b border-gray-50 pb-2">Precio y disponibilidad</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block text-xs font-semibold text-gray-700 mb-1">Precio</label>
                                <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price) }}" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                                @error('price') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="unit" class="block text-xs font-semibold text-gray-700 mb-1">Unidad de medida</label>
                                <input id="unit" name="unit" type="text" maxlength="50" value="{{ old('unit', $product->unit) }}" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                                @error('unit') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="stock" class="block text-xs font-semibold text-gray-700 mb-1">Stock disponible (opcional)</label>
                                <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $product->stock) }}"
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                                @error('stock') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="state" class="block text-xs font-semibold text-gray-700 mb-1">Estado</label>
                                <select id="state" name="state" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                                    @foreach(['Nuevo', 'Usado', 'Reacondicionado'] as $state)
                                        <option value="{{ $state }}" @selected(old('state', $product->state) === $state)>{{ $state }}</option>
                                    @endforeach
                                </select>
                                @error('state') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </section>

                    <section class="space-y-3">
                        <h2 class="text-base font-bold text-gray-900 border-b border-gray-50 pb-2">Visibilidad recomendada</h2>
                        @if($user->canSelectRecommendations() || $user->plan === 'pro_3')
                            @php($limitReached = $user->canSelectRecommendations() && !$product->is_recommended && $recommendedCount >= $recommendedLimit)
                            <label class="flex items-start gap-3 p-4 rounded-2xl border {{ $limitReached ? 'border-gray-200 bg-gray-50' : 'border-blue-100 bg-blue-50/50 cursor-pointer' }}">
                                <input type="checkbox" name="is_recommended" value="1"
                                       @checked(old('is_recommended', $product->is_recommended)) @disabled($limitReached)
                                       class="mt-0.5 rounded text-[#1d3557] focus:ring-[#1d3557]">
                                <span>
                                    <span class="block text-xs font-semibold text-gray-800">Mostrar esta publicación en recomendados</span>
                                    <span class="block text-[11px] text-gray-500 mt-1">
                                        Puedes activar o quitar esta opción cuando quieras.
                                        @if($recommendedLimit !== null) Usas {{ $recommendedCount }} de {{ $recommendedLimit }} espacios. @endif
                                    </span>
                                </span>
                            </label>
                            @if($limitReached)
                                <p class="text-xs text-amber-600">Alcanzaste el límite de productos recomendados de tu plan.</p>
                            @endif
                            @error('is_recommended') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        @else
                            <div class="flex items-center justify-between gap-4 p-4 rounded-2xl border border-gray-200 bg-gray-50">
                                <p class="text-xs text-gray-500">Tu plan actual no permite marcar publicaciones como recomendadas.</p>
                                <a href="{{ route('premium.show') }}" class="shrink-0 text-xs font-semibold text-[#1d3557] hover:underline">Ver planes</a>
                            </div>
                        @endif
                    </section>

                    <section class="space-y-4">
                        <h2 class="text-base font-bold text-gray-900 border-b border-gray-50 pb-2">Imagen</h2>
                        <div>
                            <label for="image" class="block text-xs font-semibold text-gray-700 mb-1">Reemplazar imagen principal (opcional)</label>
                            <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
                                   class="block w-full rounded-xl border border-gray-200 text-xs text-gray-600 file:mr-4 file:border-0 file:bg-[#0b132a] file:px-4 file:py-2.5 file:text-xs file:font-semibold file:text-white">
                            <p class="mt-1 text-[11px] text-gray-400">Déjalo vacío para conservar la imagen actual. Máximo 2 MB.</p>
                            @error('image') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </section>
                </div>

                <aside class="lg:col-span-5 bg-gray-50/70 p-5 rounded-2xl border border-gray-100 lg:sticky lg:top-6">
                    <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider mb-3 block">Imagen actual</span>
                    <div class="h-64 rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center">
                        @if($product->images->isNotEmpty())
                            <img id="imagePreview" src="{{ $product->images->first()->url }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                        @else
                            <img id="imagePreview" alt="Vista previa" class="hidden w-full h-full object-cover">
                            <i id="imagePlaceholder" class="bi bi-image text-4xl text-gray-300"></i>
                        @endif
                    </div>
                </aside>
            </div>

            <div class="flex justify-end pt-6 mt-8 border-t border-gray-100">
                <button type="submit" class="px-8 py-3 bg-[#0b132a] hover:bg-[#162038] text-white rounded-full text-xs font-semibold transition shadow-sm">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const preview = document.getElementById('imagePreview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            document.getElementById('imagePlaceholder')?.classList.add('hidden');
        });
    </script>
</x-sidebar-layout>
