@props(['action' => '#', 'type' => 'artwork'])

<div x-data="{ show: false, reason: '' }" 
     @report-modal.window="show = true"
     x-show="show"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="show" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="show = false"
             class="fixed inset-0 transition-opacity bg-black/80 backdrop-blur-sm"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div x-show="show" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom glass border border-white/10 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            
            <form :action="$event.target.dataset.action" method="POST" class="p-6">
                @csrf
                
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-500/20 border border-yellow-500/50">
                    <svg class="h-8 w-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <div class="mt-4 text-center">
                    <h3 class="text-xl font-bold text-white mb-2">
                        Report {{ ucfirst($type) }}
                    </h3>
                    <p class="text-gray-400 text-sm mb-4">
                        Help us keep Artoria safe. Tell us why you're reporting this {{ $type }}.
                    </p>

                    <textarea name="reason" 
                              x-model="reason"
                              rows="4" 
                              required
                              minlength="10"
                              placeholder="Please provide details about why you're reporting this content..."
                              class="w-full textarea-artoria"></textarea>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit" 
                            :disabled="reason.length < 10"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                        Submit Report
                    </button>
                    <button type="button"
                            @click="show = false" 
                            class="flex-1 px-6 py-3 glass text-gray-300 font-semibold rounded-xl hover:bg-white/10 transition-all duration-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>