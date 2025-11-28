@props(['disabled' => false, 'label' => null, 'name' => null, 'error' => null, 'options' => []])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-300 mb-2">
            {{ $label }}
        </label>
    @endif

    <select {{ $disabled ? 'disabled' : '' }} 
            {!! $attributes->merge(['class' => 'input-artoria']) !!}
            id="{{ $name }}"
            name="{{ $name }}">
        {{ $slot }}
</select>

    @if($error)
        <p class="mt-2 text-sm text-red-400">{{ $error }}</p>
    @endif
</div>