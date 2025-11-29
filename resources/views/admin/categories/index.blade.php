@extends('layouts.app')

@section('title', 'Category Management')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                    Category Management 🏷️
                </h1>
                <p class="text-gray-400">Organize artwork categories</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn-primary flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add Category</span>
            </a>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($categories as $category)
                <div class="glass rounded-2xl p-6 hover:scale-105 hover:shadow-neon-red transition-all duration-300 group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-artoria-400 transition-colors">
                                {{ $category->name }}
                            </h3>
                            @if($category->description)
                                <p class="text-gray-400 text-sm line-clamp-2">{{ $category->description }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="flex items-center space-x-6 mb-4 text-sm">
                        <div class="flex items-center text-gray-400">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-white font-semibold">{{ $category->artworks_count }}</span>
                            <span class="ml-1">artworks</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 pt-4 border-t border-white/10">
                        <a href="{{ route('admin.categories.show', $category) }}" class="flex-1 btn-secondary text-center text-sm py-2">
                            View
                        </a>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="flex-1 btn-secondary text-center text-sm py-2">
                            Edit
                        </a>
                        @if($category->artworks_count === 0)
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Delete this category?')"
                                        class="w-full px-4 py-2 bg-red-500/20 text-red-300 font-semibold rounded-xl hover:bg-red-500/30 transition-all duration-300 text-sm">
                                    Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-artoria-500/20 to-pink-500/20 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">No Categories</h3>
                    <p class="text-gray-400 mb-6">Create your first category</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn-primary inline-block">Create Category</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection