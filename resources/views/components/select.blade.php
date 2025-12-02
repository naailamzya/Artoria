@props(['disabled' => false, 'label' => null, 'name' => null, 'error' => null])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-300 mb-2">
            {{ $label }}
        </label>
    @endif

    <select {{ $disabled ? 'disabled' : '' }} 
            {!! $attributes->merge([
                'class' => 'w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#ff2b4f] focus:border-transparent transition-all duration-300'
            ]) !!}
            id="{{ $name }}"
            name="{{ $name }}">
        {{ $slot }}
    </select> 

    @if($error)
        <p class="mt-2 text-sm text-red-400">{{ $error }}</p>
    @endif
</div>