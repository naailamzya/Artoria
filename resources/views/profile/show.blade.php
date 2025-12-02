@extends('layouts.app')

@section('title', $user->name . ' - Profile')

@section('content')
<section class="relative py-12 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto space-y-6">
            @include('profile.partials.header', ['user' => $user, 'stats' => $stats ?? []])

            @if(auth()->id() === $user->id)
                @include('profile.partials.delete-user-form')
            @endif
        </div>
    </div>

    <!-- Background Effects -->
    <div class="absolute top-1/4 left-0 w-72 h-72 bg-artoria-500/10 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-1/4 right-0 w-96 h-96 bg-pink-500/10 rounded-full blur-3xl animate-float animation-delay-200"></div>
</section>

@push('styles')
<style>
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out forwards;
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    .animation-delay-200 {
        animation-delay: 0.2s;
        opacity: 0;
    }

    .animation-delay-400 {
        animation-delay: 0.4s;
        opacity: 0;
    }
</style>
@endpush
@endsection