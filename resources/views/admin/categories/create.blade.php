@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4 max-w-2xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                Create New Category
            </h1>
            <p class="text-gray-400">Add a new artwork category</p>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.categories.store') }}" method="POST" class="glass rounded-2xl p-8 space-y-6">
            @csrf

            <!-- Name -->
            <x-input 
                type="text"
                name="name"
                label="Category Name *"
                placeholder="e.g., Digital Art, Photography, 3D Modeling"
                :value="old('name')"
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
            >{{ old('description') }}</x-textarea>

            <!-- Actions -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 btn-primary py-3">
                    Create Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="flex-1 btn-secondary py-3 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection