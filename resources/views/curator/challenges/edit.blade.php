@extends('layouts.app')

@section('title', 'Edit Challenge')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">
                Edit Challenge
            </h1>
            <p class="text-gray-400">Update challenge details</p>
        </div>

        <!-- Current Banner -->
        @if($challenge->banner_image)
            <div class="glass rounded-2xl p-8 mb-6">
                <h2 class="text-xl font-bold text-white mb-4">Current Banner</h2>
                <img src="{{ $challenge->banner_url }}" 
                     alt="{{ $challenge->title }}" 
                     class="w-full max-h-96 object-cover rounded-xl">
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('curator.challenges.update', $challenge) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Banner Image -->
            <div class="glass rounded-2xl p-8">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Replace Banner (Optional)
                </h2>

                <x-file-input 
                    name="banner_image" 
                    accept="image/*"
                    :error="$errors->first('banner_image')"
                />

                <p class="mt-3 text-sm text-gray-400">
                    Leave empty to keep current banner
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
                    placeholder="e.g., Cyberpunk Dreams, Fantasy Creatures"
                    :value="old('title', $challenge->title)"
                    :error="$errors->first('title')"
                    required
                />

                <!-- Description -->
                <x-textarea 
                    name="description"
                    label="Description *"
                    placeholder="Describe the challenge theme..."
                    rows="6"
                    :error="$errors->first('description')"
                    required
                >{{ old('description', $challenge->description) }}</x-textarea>

                <!-- Rules -->
                <x-textarea 
                    name="rules"
                    label="Rules & Guidelines"
                    placeholder="List the challenge rules..."
                    rows="5"
                    :error="$errors->first('rules')"
                >{{ old('rules', $challenge->rules) }}</x-textarea>

                <!-- Prizes -->
                <x-textarea 
                    name="prizes"
                    label="Prizes"
                    placeholder="Describe the prizes..."
                    rows="4"
                    :error="$errors->first('prizes')"
                >{{ old('prizes', $challenge->prizes) }}</x-textarea>
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
                        :value="old('start_date', $challenge->start_date->format('Y-m-d'))"
                        :error="$errors->first('start_date')"
                        required
                    />

                    <!-- End Date -->
                    <x-input 
                        type="date"
                        name="end_date"
                        label="End Date *"
                        :value="old('end_date', $challenge->end_date->format('Y-m-d'))"
                        :error="$errors->first('end_date')"
                        required
                    />
                </div>
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
                    <option value="draft" {{ old('status', $challenge->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="active" {{ old('status', $challenge->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="ended" {{ old('status', $challenge->status) === 'ended' ? 'selected' : '' }}>Ended</option>
                </x-select>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="btn-primary flex-1 flex items-center justify-center space-x-2 py-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-lg font-semibold">Save Changes</span>
                </button>
                <a href="{{ route('curator.dashboard') }}" class="btn-secondary flex-1 flex items-center justify-center space-x-2 py-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="text-lg font-semibold">Cancel</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection