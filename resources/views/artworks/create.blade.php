@extends('layouts.app')

@section('title', 'Upload Artwork')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                Upload Your Artwork
            </h1>
            <p class="text-gray-400">Share your creativity with the world</p>
        </div>

        <!-- Form -->
        <form action="{{ route('artworks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Image Upload -->
            <div class="glass rounded-2xl p-8">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Artwork Image *
                </h2>

                <x-file-input 
                    name="image" 
                    accept="image/*"
                    :error="$errors->first('image')"
                />

                <p class="mt-3 text-sm text-gray-400">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Recommended: High resolution images (at least 1920x1080). Max file size: 5MB
                </p>
            </div>

            <!-- Artwork Details -->
            <div class="glass rounded-2xl p-8 space-y-6">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Artwork Details
                </h2>

                <!-- Title -->
                <x-input 
                    type="text"
                    name="title"
                    label="Title *"
                    placeholder="Give your artwork a catchy title"
                    :value="old('title')"
                    :error="$errors->first('title')"
                    required
                />

                <!-- Description -->
                <x-textarea 
                    name="description"
                    label="Description"
                    placeholder="Tell us about your artwork, your inspiration, techniques used..."
                    rows="6"
                    :error="$errors->first('description')"
                >{{ old('description') }}</x-textarea>

                <!-- Category -->
                <x-select 
                    name="category_id"
                    label="Category *"
                    :error="$errors->first('category_id')"
                    required
                >
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-select>

                <!-- Tags -->
                <div x-data="tagInput()" x-init="init()">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Tags
                        <span class="text-gray-500 font-normal">(separate with commas)</span>
                    </label>
                    
                    <input 
                        type="text" 
                        x-model="inputValue"
                        @keydown.enter.prevent="addTag()"
                        @keydown.comma.prevent="addTag()"
                        placeholder="e.g., digital art, fantasy, character design"
                        class="input-artoria"
                    >
                    
                    <input type="hidden" name="tags" x-model="tagsString">

                    <!-- Tag Display -->
                    <div class="flex flex-wrap gap-2 mt-3" x-show="tags.length > 0">
                        <template x-for="(tag, index) in tags" :key="index">
                            <span class="tag flex items-center space-x-2">
                                <span x-text="'#' + tag"></span>
                                <button type="button" 
                                        @click="removeTag(index)"
                                        class="hover:text-red-400 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </span>
                        </template>
                    </div>

                    @error('tags')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror

                    <!-- Popular Tags Suggestions -->
                    @if($popularTags->count() > 0)
                        <div class="mt-4">
                            <p class="text-sm text-gray-400 mb-2">Popular tags:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($popularTags->take(15) as $tag)
                                    <button type="button" 
                                            @click="addTagFromSuggestion('{{ $tag->name }}')"
                                            class="text-xs px-3 py-1 glass rounded-full text-gray-300 hover:bg-artoria-500/20 hover:text-artoria-300 transition-all duration-300">
                                        #{{ $tag->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="btn-primary flex-1 flex items-center justify-center space-x-2 py-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <span class="text-lg font-semibold">Upload Artwork</span>
                </button>
                <a href="{{ route('dashboard') }}" class="btn-secondary flex-1 flex items-center justify-center space-x-2 py-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="text-lg font-semibold">Cancel</span>
                </a>
            </div>
        </form>

        <!-- Tips Section -->
        <div class="mt-8 glass rounded-2xl p-6">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Tips for Great Uploads
            </h3>
            <ul class="space-y-2 text-gray-300 text-sm">
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 text-artoria-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Use a descriptive title that captures the essence of your work</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 text-artoria-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Add relevant tags to help people discover your artwork</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 text-artoria-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Share your creative process or inspiration in the description</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 text-artoria-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Upload high-quality images for the best viewing experience</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script>
function tagInput() {
    return {
        tags: [],
        inputValue: '',
        tagsString: '',
        
        init() {
            // Load old tags if validation failed
            const oldTags = '{{ old("tags") }}';
            if (oldTags) {
                this.tags = oldTags.split(',').map(t => t.trim()).filter(t => t);
                this.updateTagsString();
            }
        },
        
        addTag() {
            const tag = this.inputValue.trim().toLowerCase().replace(/[^a-z0-9\s-]/g, '');
            if (tag && !this.tags.includes(tag) && this.tags.length < 10) {
                this.tags.push(tag);
                this.inputValue = '';
                this.updateTagsString();
            }
        },
        
        addTagFromSuggestion(tag) {
            if (!this.tags.includes(tag) && this.tags.length < 10) {
                this.tags.push(tag);
                this.updateTagsString();
            }
        },
        
        removeTag(index) {
            this.tags.splice(index, 1);
            this.updateTagsString();
        },
        
        updateTagsString() {
            this.tagsString = this.tags.join(',');
        }
    }
}
</script>
@endpush
@endsection