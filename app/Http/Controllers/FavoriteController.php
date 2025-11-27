<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FavoriteController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display user's favorites
     */
    public function index()
    {
        $favorites = auth()->user()
            ->favorites()
            ->with(['artwork.user', 'artwork.category', 'artwork.tags'])
            ->latest()
            ->paginate(24);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Add artwork to favorites
     */
    public function store(Artwork $artwork)
    {
        $this->authorize('interact', $artwork);

        if (auth()->user()->hasFavorited($artwork)) {
            return back()->with('info', 'Already in your favorites.');
        }

        auth()->user()->favorites()->create([
            'artwork_id' => $artwork->id,
        ]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Added to favorites',
            ]);
        }

        return back()->with('success', 'Added to favorites!');
    }

    /**
     * Remove artwork from favorites
     */
    public function destroy(Artwork $artwork)
    {
        $this->authorize('interact', $artwork);

        $favorite = auth()->user()->favorites()->where('artwork_id', $artwork->id)->first();

        if (!$favorite) {
            return back()->with('info', 'Not in your favorites.');
        }

        $favorite->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Removed from favorites',
            ]);
        }

        return back()->with('success', 'Removed from favorites.');
    }
}