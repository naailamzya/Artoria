<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report Artwork') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Artwork Preview -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-semibold text-gray-900 mb-2">Reporting Artwork:</h3>
                        <div class="flex gap-4">
                            <img src="{{ asset('storage/' . $artwork->file_path) }}" 
                                alt="{{ $artwork->title }}" 
                                class="w-32 h-32 object-cover rounded">
                            <div>
                                <p class="font-semibold">{{ $artwork->title }}</p>
                                <p class="text-sm text-gray-600">by {{ $artwork->user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('reports.store', $artwork->id) }}" method="POST">
                        @csrf

                        <!-- Reason -->
                        <div class="mb-6">
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                                Reason <span class="text-red-500">*</span>
                            </label>
                            <select name="reason" id="reason" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select a reason...</option>
                                <option value="SARA" {{ old('reason') == 'SARA' ? 'selected' : '' }}>SARA</option>
                                <option value="Plagiat" {{ old('reason') == 'Plagiat' ? 'selected' : '' }}>Plagiat</option>
                                <option value="Konten Tidak Pantas" {{ old('reason') == 'Konten Tidak Pantas' ? 'selected' : '' }}>Konten Tidak Pantas</option>
                                <option value="Spam" {{ old('reason') == 'Spam' ? 'selected' : '' }}>Spam</option>
                                <option value="Lainnya" {{ old('reason') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('reason')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Detailed Description <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" id="description" rows="6" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Please provide detailed information about why you're reporting this artwork...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded p-4 mb-6">
                            <p class="text-sm text-yellow-800">
                                ⚠️ False reports may result in account suspension. Please report only if you have genuine concerns.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4">
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                                Submit Report
                            </button>
                            <a href="{{ route('artworks.show', $artwork->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>