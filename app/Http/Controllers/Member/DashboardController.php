<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $recentArtworks = $user->artworks()
            ->with(['category', 'tags'])
            ->latest()
            ->limit(6)
            ->get();

        $stats = [
            'artworks_count' => $user->artworks()->count(),
            'total_likes' => $user->artworks()->sum('likes_count'),
            'total_views' => $user->artworks()->sum('views_count'),
            'favorites_count' => $user->favorites()->count(),
            'comments_count' => $user->comments()->count(),
        ];

        $recentLikes = $user->likes()
            ->with(['artwork.user', 'artwork.category'])
            ->latest()
            ->limit(5)
            ->get();

        $recentComments = $user->comments()
            ->with(['artwork.user'])
            ->latest()
            ->limit(5)
            ->get();

        return view('member.dashboard', compact(
            'user',
            'recentArtworks',
            'stats',
            'recentLikes',
            'recentComments'
        ));
    }
}