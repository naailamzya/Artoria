@extends('layouts.app')

@section('title', 'Curator Application Pending')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-2xl w-full">
        <!-- Animation Container -->
        <div class="text-center mb-8">
            <div class="relative inline-block">
                <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-yellow-500/20 to-orange-500/20 rounded-full flex items-center justify-center animate-pulse-slow">
                    <svg class="w-16 h-16 text-yellow-400 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <!-- Orbiting dots -->
                <div class="absolute top-0 left-1/2 w-4 h-4 bg-yellow-400 rounded-full animate-orbit"></div>
                <div class="absolute top-1/2 right-0 w-3 h-3 bg-orange-400 rounded-full animate-orbit-reverse"></div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="glass rounded-3xl p-8 md:p-12 border-2 border-yellow-500/30 shadow-2xl">
            <div class="text-center space-y-6">
                <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-4">
                    Your Curator Application is <span class="gradient-text">Under Review</span> ⏳
                </h1>
                
                <p class="text-xl text-gray-300 leading-relaxed">
                    Thank you for applying to become a curator on Artoria! Our admin team is carefully reviewing your application.
                </p>

                <!-- Status Timeline -->
                <div class="glass rounded-2xl p-6 mt-8">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <h3 class="text-white font-semibold">Application Submitted</h3>
                                <p class="text-sm text-gray-400">Your curator application has been received</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0 animate-pulse">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <h3 class="text-white font-semibold">Under Review</h3>
                                <p class="text-sm text-gray-400">Admin team is reviewing your profile and portfolio</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <h3 class="text-gray-500 font-semibold">Approval Decision</h3>
                                <p class="text-sm text-gray-500">You'll be notified once a decision is made</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- What Happens Next -->
                <div class="glass rounded-2xl p-6 mt-8 text-left">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-artoria-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        What Happens Next?
                    </h3>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 text-artoria-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Our admin team will review your profile and artwork portfolio</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 text-artoria-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Review typically takes 1-3 business days</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 text-artoria-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>You'll receive an email notification with the decision</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 text-artoria-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>If approved, you'll gain access to the Curator Dashboard</span>
                        </li>
                    </ul>
                </div>

                <!-- Meanwhile Section -->
                <div class="mt-8 pt-8 border-t border-white/10">
                    <h3 class="text-lg font-bold text-white mb-4">Meanwhile, you can:</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <a href="{{ route('artworks.create') }}" class="glass-hover rounded-xl p-4 transition-all duration-300">
                            <svg class="w-8 h-8 text-artoria-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <p class="text-white font-semibold text-sm">Upload Art</p>
                        </a>
                        <a href="{{ route('challenges.index') }}" class="glass-hover rounded-xl p-4 transition-all duration-300">
                            <svg class="w-8 h-8 text-artoria-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            <p class="text-white font-semibold text-sm">Join Challenges</p>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="glass-hover rounded-xl p-4 transition-all duration-300">
                            <svg class="w-8 h-8 text-artoria-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <p class="text-white font-semibold text-sm">Edit Profile</p>
                        </a>
                    </div>
                </div>

                <!-- Back to Dashboard -->
                <div class="mt-8">
                    <a href="{{ route('dashboard') }}" class="btn-secondary inline-flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Back to Dashboard</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    @keyframes orbit {
        from { transform: rotate(0deg) translateX(80px) rotate(0deg); }
        to { transform: rotate(360deg) translateX(80px) rotate(-360deg); }
    }
    
    @keyframes orbit-reverse {
        from { transform: rotate(360deg) translateX(-80px) rotate(-360deg); }
        to { transform: rotate(0deg) translateX(-80px) rotate(0deg); }
    }
    
    .animate-spin-slow {
        animation: spin-slow 3s linear infinite;
    }
    
    .animate-orbit {
        animation: orbit 4s linear infinite;
    }
    
    .animate-orbit-reverse {
        animation: orbit-reverse 5s linear infinite;
    }
</style>
@endpush
@endsection