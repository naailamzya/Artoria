<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $activeChallenges = Challenge::where('curator_id', $user->id)
            ->active()
            ->withCount('entries')
            ->latest()
            ->get();

        $endedChallenges = Challenge::where('curator_id', $user->id)
            ->ended()
            ->withCount('entries')
            ->latest()
            ->limit(5)
            ->get();

        $draftChallenges = Challenge::where('curator_id', $user->id)
            ->where('status', 'draft')
            ->withCount('entries')
            ->latest()
            ->get();

        $stats = [
            'total_challenges' => Challenge::where('curator_id', $user->id)->count(),
            'active_challenges' => Challenge::where('curator_id', $user->id)->active()->count(),
            'total_submissions' => Challenge::where('curator_id', $user->id)
                ->withCount('entries')
                ->get()
                ->sum('entries_count'),
            'total_participants' => Challenge::where('curator_id', $user->id)
                ->with('entries')
                ->get()
                ->pluck('entries')
                ->flatten()
                ->pluck('user_id')
                ->unique()
                ->count(),
        ];

        $recentSubmissions = Challenge::where('curator_id', $user->id)
            ->with(['entries' => function ($query) {
                $query->with(['artwork.user', 'artwork.category'])
                    ->latest()
                    ->limit(10);
            }])
            ->get()
            ->pluck('entries')
            ->flatten()
            ->sortByDesc('created_at')
            ->take(10);

        return view('curator.dashboard', compact(
            'activeChallenges',
            'endedChallenges',
            'draftChallenges',
            'stats',
            'recentSubmissions'
        ));
    }
}