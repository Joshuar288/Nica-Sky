@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'px-4 py-2.5 rounded-xl border border-gray-200 text-xs text-gray-800 outline-none focus:border-[#0b132a] focus:ring-1 focus:ring-[#0b132a]']) }}>
