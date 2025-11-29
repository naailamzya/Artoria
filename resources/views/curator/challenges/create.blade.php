@extends('layouts.app')

@section('title', 'Create Challenge')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                Create New Challenge 🎯
            </h1>
            <p class="text-gray-400">Launch an exciting art competition for the community</p>
        </div>

        <!-- Form -->
        <form action="{{ route('curator.challenges.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Banner Image -->
            <div class="glass rounded-2xl p-8">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Challenge Banner
                </h2>

                <x-file-input 
                    name="banner_image" 
                    accept="image/*"
                    :error="$errors->first('banner_image')"
                />

                <p class="mt-3 text-sm text-gray-400">
                    Recommended size: 1920x600px for best results
                </p>
            </div>

            <!-- Challenge Details -->
            <div class="glass rounded-2xl p-8 space-y-6">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Challenge Details
                </h2>

                <!-- Title -->
                <x-input 
                    type="text"
                    name="title"
                    label="Challenge Title *"
                    placeholder="e.g., Cyberpunk Dreams, Fantasy Creatures, Neon Nights"
                    :value="old('title')"
                    :error="$errors->first('title')"
                    required
                />

                <!-- Description -->
                <x-textarea 
                    name="description"
                    label="Description *"
                    placeholder="Describe the challenge theme, what participants should create, and any specific requirements..."
                    rows="6"
                    :error="$errors->first('description')"
                    required
                >{{ old('description') }}</x-textarea>

                <!-- Rules -->
                <x-textarea 
                    name="rules"
                    label="Rules & Guidelines"
                    placeholder="List the challenge rules, requirements, and submission guidelines..."
                    rows="5"
                    :error="$errors->first('rules')"
                >{{ old('rules') }}</x-textarea>

                <!-- Prizes -->
                <x-textarea 
                    name="prizes"
                    label="Prizes"
                    placeholder="Describe the prizes for winners (e.g., cash, features, recognition)..."
                    rows="4"
                    :error="$errors->first('prizes')"
                >{{ old('prizes') }}</x-textarea>
            </div>

            <!-- Timeline -->
            <div class="glass rounded-2xl p-8 space-y-6">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Timeline
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Start Date -->
                    <x-input 
                        type="date"
                        name="start_date"
                        label="Start Date *"
                        :value="old('start_date', now()->format('Y-m-d'))"
                        :error="$errors->first('start_date')"
                        required
                    />

                    <!-- End Date -->
                    <x-input 
                        type="date"
                        name="end_date"
                        label="End Date *"
                        :value="old('end_date', now()->addDays(30)->format('Y-m-d'))"
                        :error="$errors->first('end_date')"
                        required
                    />
                </div>

                <p class="text-sm text-gray-400">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Participants can submit artworks between these dates
                </p>
            </div>

            <!-- Status -->
            <div class="glass rounded-2xl p-8">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Publication Status
                </h2>

                <x-select 
                    name="status"
                    label="Status *"
                    :error="$errors->first('status')"
                    required
                >
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Save without publishing)</option>
                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active (Publish immediately)</option>
                </x-select>

                <p class="mt-3 text-sm text-gray-400">
                    Save as draft to review later, or set to active to publish immediately
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="btn-primary flex-1 flex items-center justify-center space-x-2 py-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-lg font-semibold">Create Challenge</span>
                </button>
                <a href="{{ route('curator.dashboard') }}" class="btn-secondary flex-1 flex items-center justify-center space-x-2 py-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="text-lg font-semibold">Cancel</span>
                </a>
            </div>
        </form>

        <!-- Tips -->
        <div class="mt-8 glass rounded-2xl p-6">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Tips for Great Challenges
            </h3>
            <ul class="space-y-2 text-gray-300 text-sm">
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 text-artoria-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Make the theme clear and inspiring</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 text-artoria-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Set clear rules and guidelines</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 text-artoria-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Give participants enough time (2-4 weeks recommended)</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 text-artoria-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Offer attractive prizes to motivate participation</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection