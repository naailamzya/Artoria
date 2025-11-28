@props(['label' => null, 'name' => null, 'accept' => 'image/*', 'error' => null])

<div x-data="{ fileName: '', preview: null }">
    @if($label)
        <label class="block text-sm font-medium text-gray-300 mb-2">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <input type="file" 
               name="{{ $name }}" 
               id="{{ $name }}"
               accept="{{ $accept }}"
               class="hidden"
               @change="fileName = $event.target.files[0]?.name || ''; 
                        if($event.target.files[0]) {
                            const reader = new FileReader();
                            reader.onload = (e) => preview = e.target.result;
                            reader.readAsDataURL($event.target.files[0]);
                        }">
        
        <label for="{{ $name }}" 
               class="flex items-center justify-center w-full px-4 py-3 glass rounded-xl border-2 border-dashed border-white/20 hover:border-artoria-500/50 cursor-pointer transition-all duration-300 group">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-artoria-400 transition-colors duration-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="mt-2 text-sm text-gray-300" x-show="!fileName">
                    <span class="font-semibold text-artoria-400">Click to upload</span> or drag and drop
                </p>
                <p class="mt-2 text-sm text-artoria-400" x-show="fileName" x-text="fileName"></p>
                <p class="mt-1 text-xs text-gray-400">PNG, JPG, GIF up to 5MB</p>
            </div>
        </label>

        <div x-show="preview" class="mt-4" style="display: none;">
            <img :src="preview" class="w-full h-48 object-cover rounded-xl">
        </div>
    </div>

    @if($error)
        <p class="mt-2 text-sm text-red-400">{{ $error }}</p>
    @endif
</div>