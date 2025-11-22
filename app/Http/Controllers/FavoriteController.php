<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('artwork.user', 'artwork.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    public function toggle($artworkId)
    {
        $artwork = Artwork::findOrFail($artworkId);

        $existingFavorite = Favorite::where('user_id', Auth::id())
            ->where('artwork_id', $artworkId)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            $message = 'Removed from favorites';
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'artwork_id' => $artworkId,
            ]);
            $message = 'Added to favorites!';
        }

        return back()->with('success', $message);
    }
}