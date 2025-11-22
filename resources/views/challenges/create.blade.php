<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Challenge') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <form action="{{ route('challenges.store') }}" method="POST">
                        @csrf

                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Challenge Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rules -->
                        <div class="mb-6">
                            <label for="rules" class="block text-sm font-medium text-gray-700 mb-2">
                                Rules (Optional)
                            </label>
                            <textarea name="rules" id="rules" rows="4"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="1. Rule one&#10;2. Rule two&#10;3. Rule three">{{ old('rules') }}</textarea>
                            @error('rules')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Reward -->
                        <div class="mb-6">
                            <label for="reward" class="block text-sm font-medium text-gray-700 mb-2">
                                Reward (Rp) (Optional)
                            </label>
                            <input type="number" name="reward" id="reward" value="{{ old('reward') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                min="0" step="1000">
                            @error('reward')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deadline -->
                        <div class="mb-6">
                            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">
                                Deadline <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="deadline" id="deadline" value="{{ old('deadline') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            @error('deadline')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded p-4 mb-6">
                            <p class="text-sm text-yellow-800">
                                ⚠️ Your challenge will be submitted to admin for approval before it goes live.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4">
                            <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded">
                                Create Challenge
                            </button>
                            <a href="{{ route('challenges.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>