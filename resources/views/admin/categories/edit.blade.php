@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4 max-w-2xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                Edit Category
            </h1>
            <p class="text-gray-400">Update category details</p>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="glass rounded-2xl p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <x-input 
                type="text"
                name="name"
                label="Category Name *"
                placeholder="e.g., Digital Art, Photography"
                :value="old('name', $category->name)"
                :error="$errors->first('name')"
                required
            />

            <!-- Description -->
            <x-textarea 
                name="description"
                label="Description"
                placeholder="Brief description of this category..."
                rows="4"
                :error="$errors->first('description')"
            >{{ old('description', $category->description) }}</x-textarea>

            <!-- Stats -->
            <div class="glass rounded-xl p-4 border-2 border-artoria-500/30">
                <p class="text-sm text-gray-400 mb-2">Current Stats:</p>
                <div class="flex items-center space-x-4 text-white">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <strong>{{ $category->artworks()->count() }}</strong>&nbsp;artworks
                    </span>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 btn-primary py-3">
                    Save Changes
                </button>
                <a href="{{ route('admin.categories.index') }}" class="flex-1 btn-secondary py-3 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection