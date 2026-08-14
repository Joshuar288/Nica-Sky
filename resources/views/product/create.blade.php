<x-sidebar-layout>
    <x-slot:title>
        Crear publicacion - NicaSky
    </x-slot:title>

    <div class="max-w-5xl mx-auto bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-100 pb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Crear publicación</h1>
                <p class="text-xs text-gray-400 mt-1">Ingresa los datos correspondientes para publicar tu producto en NicaSky</p>
            </div>
            <a href="{{ route('myprofile.show') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full text-xs font-semibold flex items-center gap-2 transition">
                <i class="bi bi-arrow-left"></i>
                <span>Cancelar</span>
            </a>
        </div>

        <!-- Formulario -->
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Formulario Izquierda (7 columnas) -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- Información Principal -->
                    <div class="space-y-4">
                        <h3 class="text-base font-bold text-gray-900 border-b border-gray-50 pb-2">Información del producto</h3>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Título de la publicación</label>
                            <input type="text" id="inputTitle" name="title" value="{{ old('title') }}" placeholder="Ej. Nike Dunk Low" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                            @error('title') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Descripción</label>
                            <textarea id="inputDescription" name="description" rows="3" placeholder="Agrega una breve descripción..." required
                                      class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a] resize-none">{{ old('description') }}</textarea>
                            @error('description') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Categoría</label>
                            <select id="selectCategory" name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                                <option value="" disabled selected>Selecciona una categoría</option>
                                @foreach($categories->groupBy('type_category') as $type => $group)
                                    <optgroup label="{{ $type }}">
                                        @foreach($group as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Precio y Stock -->
                    <div class="space-y-4 pt-2">
                        <h3 class="text-base font-bold text-gray-900 border-b border-gray-50 pb-2">Precio y disponibilidad</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Precio (C$ / $)</label>
                                <input type="number" step="0.01" id="inputPrice" name="price" value="{{ old('price') }}" placeholder="0.00" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                                @error('price') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Unidad de Medida</label>
                                <input type="text" id="inputUnit" name="unit" value="{{ old('unit', 'Unidad') }}" placeholder="Ej. Par, Pieza, Libra" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                                @error('unit') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Stock Disponible (Opcional)</label>
                                <input type="number" name="stock" value="{{ old('stock') }}" placeholder="Ej. 10"
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                                @error('stock') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Estado del Producto</label>
                                <select id="selectState" name="state" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]">
                                    <option value="Nuevo" {{ old('state') == 'Nuevo' ? 'selected' : '' }}>Nuevo</option>
                                    <option value="Usado" {{ old('state') == 'Usado' ? 'selected' : '' }}>Usado</option>
                                    <option value="Reacondicionado" {{ old('state') == 'Reacondicionado' ? 'selected' : '' }}>Reacondicionado</option>
                                </select>
                                @error('state') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Multimedia -->
                    <div class="space-y-4 pt-2">
                        <h3 class="text-base font-bold text-gray-900 border-b border-gray-50 pb-2">Imagen</h3>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Imagen Principal</label>
                            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 flex flex-col items-center justify-center text-center cursor-pointer hover:border-[#0b132a] transition relative bg-gray-50">
                                <input type="file" id="inputImage" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" required>
                                <i class="bi bi-cloud-arrow-up text-3xl text-gray-400 mb-1"></i>
                                <p class="text-xs font-medium text-gray-700">Haz clic para subir o arrastra la imagen aquí</p>
                                <span class="text-[10px] text-gray-400 mt-1">PNG, JPG o WEBP (Máx. 2MB)</span>
                            </div>
                            @error('image') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>

                <!-- Columna Derecha: Vista Previa Fija (5 columnas) -->
                <div class="lg:col-span-5 bg-gray-50/70 p-5 rounded-2xl border border-gray-100 sticky top-6">
                    <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider mb-3 block">Vista previa en tiempo real</span>
                    
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between">
                        <div class="h-48 rounded-xl overflow-hidden mb-3 bg-gray-100 flex items-center justify-center relative">
                            <img id="previewImage" class="w-full h-full object-cover hidden">
                            <i id="previewIcon" class="bi bi-image text-3xl text-gray-300"></i>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <h4 id="previewTitle" class="font-bold text-gray-900 text-xs truncate">Título del Producto</h4>
                                <span id="previewPrice" class="font-bold text-[#1d3557] text-xs">$0.00</span>
                            </div>
                            
                            <span id="previewCategory" class="inline-block text-[10px] font-semibold text-[#1d3557] bg-blue-50 px-2 py-0.5 rounded-md mb-2">
                                Sin categoría
                            </span>

                            <p id="previewDescription" class="text-[11px] text-gray-400 line-clamp-2 mb-3">La descripción de tu publicación aparecerá aquí.</p>
                            
                            <div class="flex items-center justify-between pt-2.5 border-t border-gray-100 text-[10px] text-gray-400">
                                <span id="previewState">Estado: Nuevo</span>
                                <span id="previewUnit">Unidad</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-gray-200/60 flex justify-between items-center text-[11px] text-gray-500">
                        <span>Vendedor: {{ auth()->user()->name }}</span>
                        <span id="previewBadgeState" class="px-2 py-0.5 bg-gray-200 rounded-md font-semibold text-gray-700">Nuevo</span>
                    </div>
                </div>

            </div>

            <!-- Botón Único -->
            <div class="flex justify-end items-center pt-6 mt-8 border-t border-gray-100">
                <button type="submit" class="px-8 py-3 bg-[#0b132a] hover:bg-[#162038] text-white rounded-full text-xs font-semibold transition shadow-sm">
                    Publicar Producto
                </button>
            </div>

        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputTitle = document.getElementById('inputTitle');
            const inputDescription = document.getElementById('inputDescription');
            const selectCategory = document.getElementById('selectCategory');
            const inputPrice = document.getElementById('inputPrice');
            const inputUnit = document.getElementById('inputUnit');
            const selectState = document.getElementById('selectState');
            const inputImage = document.getElementById('inputImage');

            inputTitle.addEventListener('input', e => {
                document.getElementById('previewTitle').textContent = e.target.value || 'Título del Producto';
            });

            inputDescription.addEventListener('input', e => {
                document.getElementById('previewDescription').textContent = e.target.value || 'La descripción de tu publicación aparecerá aquí.';
            });

            selectCategory.addEventListener('change', e => {
                const selectedOption = e.target.options[e.target.selectedIndex];
                document.getElementById('previewCategory').textContent = selectedOption.text || 'Sin categoría';
            });

            inputPrice.addEventListener('input', e => {
                document.getElementById('previewPrice').textContent = e.target.value ? `$${e.target.value}` : '$0.00';
            });

            inputUnit.addEventListener('input', e => {
                document.getElementById('previewUnit').textContent = e.target.value || 'Unidad';
            });

            selectState.addEventListener('change', e => {
                document.getElementById('previewState').textContent = `Estado: ${e.target.value}`;
                document.getElementById('previewBadgeState').textContent = e.target.value;
            });

            inputImage.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewImg = document.getElementById('previewImage');
                const previewIcon = document.getElementById('previewIcon');

                if (file) {
                    previewImg.src = URL.createObjectURL(file);
                    previewImg.classList.remove('hidden');
                    previewIcon.classList.add('hidden');
                }
            });
        });
    </script>
</x-sidebar-layout>