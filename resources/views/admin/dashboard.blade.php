<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-gray-600 text-sm font-semibold">Pending Reports</h3>
                        <p class="text-3xl font-bold text-red-600">{{ $pendingReports }}</p>
                        <a href="{{ route('admin.reports') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                            View Reports →
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-gray-600 text-sm font-semibold">Pending Challenges</h3>
                        <p class="text-3xl font-bold text-purple-600">{{ $pendingChallenges }}</p>
                        <a href="{{ route('admin.challenges') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                            Review Challenges →
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-gray-600 text-sm font-semibold">Total Users</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
                        <a href="{{ route('admin.users') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                            Manage Users →
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-gray-600 text-sm font-semibold">Total Artworks</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $totalArtworks }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('admin.reports') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-4 px-6 rounded text-center">
                            🚨 Manage Reports
                        </a>
                        <a href="{{ route('admin.challenges') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-4 px-6 rounded text-center">
                            🏆 Review Challenges
                        </a>
                        <a href="{{ route('admin.users') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded text-center">
                            👥 Manage Users
                        </a>
                        <a href="{{ route('admin.categories') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-4 px-6 rounded text-center">
                            📁 Manage Categories
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>