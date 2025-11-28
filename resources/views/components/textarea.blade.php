@props(['disabled' => false, 'label' => null, 'name' => null, 'error' => null, 'rows' => 4])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-300 mb-2">
            {{ $label }}
        </label>
    @endif

    <textarea {{ $disabled ? 'disabled' : '' }} 
              rows="{{ $rows }}"
              {!! $attributes->merge(['class' => 'textarea-artoria']) !!}
              id="{{ $name }}"
              name="{{ $name }}">{{ $slot }}</textarea>

    @if($error)
        <p class="mt-2 text-sm text-red-400">{{ $error }}</p>
    @endif
</div>