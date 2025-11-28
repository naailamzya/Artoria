<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Artwork;
use App\Models\Challenge;
use App\Models\Report;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_members' => User::where('role', 'member')->count(),
            'total_curators' => User::where('role', 'curator')->where('status', 'active')->count(),
            'pending_curators' => User::where('role', 'curator')->where('status', 'pending')->count(),
            'total_artworks' => Artwork::count(),
            'total_challenges' => Challenge::count(),
            'active_challenges' => Challenge::active()->count(),
            'pending_reports' => Report::pending()->count(),
            'total_categories' => Category::count(),
        ];

        $recentArtworks = Artwork::with(['user', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        $recentUsers = User::latest()
            ->limit(5)
            ->get();

        $recentReports = Report::with(['reporter', 'reportable'])
            ->pending()
            ->latest()
            ->limit(5)
            ->get();

        $popularArtworks = Artwork::with(['user', 'category'])
            ->orderBy('likes_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentArtworks',
            'recentUsers',
            'recentReports',
            'popularArtworks'
        ));
    }

    public function statistics()
    {
        $userStats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'suspended_users' => User::where('status', 'suspended')->count(),
            'pending_users' => User::where('status', 'pending')->count(),
            'members' => User::where('role', 'member')->count(),
            'curators' => User::where('role', 'curator')->where('status', 'active')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];

        $contentStats = [
            'total_artworks' => Artwork::count(),
            'total_likes' => Artwork::sum('likes_count'),
            'total_views' => Artwork::sum('views_count'),
            'total_comments' => DB::table('comments')->count(),
            'total_favorites' => DB::table('favorites')->count(),
        ];

        $challengeStats = [
            'total_challenges' => Challenge::count(),
            'active_challenges' => Challenge::active()->count(),
            'ended_challenges' => Challenge::ended()->count(),
            'draft_challenges' => Challenge::where('status', 'draft')->count(),
            'total_submissions' => DB::table('challenge_entries')->count(),
        ];

        $moderationStats = [
            'total_reports' => Report::count(),
            'pending_reports' => Report::pending()->count(),
            'reviewed_reports' => Report::reviewed()->count(),
            'dismissed_reports' => Report::where('status', 'dismissed')->count(),
        ];

        $topContributors = User::withCount('artworks')
            ->where('role', '!=', 'admin')
            ->orderBy('artworks_count', 'desc')
            ->limit(10)
            ->get();

        $topArtworks = Artwork::with(['user', 'category'])
            ->orderBy('likes_count', 'desc')
            ->limit(10)
            ->get();

        $categoryDistribution = Category::withCount('artworks')
            ->orderBy('artworks_count', 'desc')
            ->get();

        $monthlyGrowth = User::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.statistics', compact(
            'userStats',
            'contentStats',
            'challengeStats',
            'moderationStats',
            'topContributors',
            'topArtworks',
            'categoryDistribution',
            'monthlyGrowth'
        ));
    }
}