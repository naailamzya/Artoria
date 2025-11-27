<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Challenge;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        $featuredArtworks = Artwork::with(['user', 'category', 'tags'])
            ->featured()
            ->limit(6)
            ->get();

        $popularArtworks = Artwork::with(['user', 'category', 'tags'])
            ->popular()
            ->limit(12)
            ->get();

        $latestArtworks = Artwork::with(['user', 'category', 'tags'])
            ->latest()
            ->limit(12)
            ->get();

        $activeChallenges = Challenge::with('curator')
            ->active()
            ->limit(3)
            ->get();

        $popularTags = Tag::popular(20)->get();

        $categories = Category::withCount('artworks')
            ->orderBy('artworks_count', 'desc')
            ->get();

        return view('home', compact(
            'featuredArtworks',
            'popularArtworks',
            'latestArtworks',
            'activeChallenges',
            'popularTags',
            'categories'
        ));
    }
}