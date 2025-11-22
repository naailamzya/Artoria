<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    @if($reports->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Artwork</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reported By</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reports as $report)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <img src="{{ asset('storage/' . $report->artwork->file_path) }}" 
                                                        class="w-16 h-16 object-cover rounded mr-3">
                                                    <div>
                                                        <a href="{{ route('artworks.show', $report->artwork->id) }}" 
                                                            class="text-blue-600 hover:underline font-medium">
                                                            {{ $report->artwork->title }}
                                                        </a>
                                                        <p class="text-sm text-gray-500">by {{ $report->artwork->user->name }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $report->user->name }}</td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ $report->reason }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                                                {{ $report->description }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($report->status === 'pending')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @elseif($report->status === 'reviewed')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Reviewed
                                                    </span>
                                                @elseif($report->status === 'dismissed')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Dismissed
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Taken Down
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                @if($report->status === 'pending')
                                                    <div class="flex gap-2">
                                                        <form action="{{ route('admin.reports.review', $report->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="action" value="dismiss">
                                                            <button type="submit" class="text-gray-600 hover:text-gray-900 font-medium"
                                                                onclick="return confirm('Dismiss this report?')">
                                                                Dismiss
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.reports.review', $report->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="action" value="take_down">
                                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium"
                                                                onclick="return confirm('Take down this artwork?')">
                                                                Take Down
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">{{ ucfirst($report->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $reports->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No reports found.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>