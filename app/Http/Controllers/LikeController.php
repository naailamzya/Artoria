<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LikeController extends Controller
{
    use AuthorizesRequests;

    /**
     * Like an artwork
     */
    public function store(Artwork $artwork)
    {
        $this->authorize('interact', $artwork);

        if (auth()->user()->hasLiked($artwork)) {
            return back()->with('info', 'You already liked this artwork.');
        }

        auth()->user()->likes()->create([
            'artwork_id' => $artwork->id,
        ]);

        $artwork->incrementLikes();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'likes_count' => $artwork->fresh()->likes_count,
            ]);
        }

        return back()->with('success', 'Artwork liked! ❤️');
    }

    /**
     * Unlike an artwork
     */
    public function destroy(Artwork $artwork)
    {
        $this->authorize('interact', $artwork);

        $like = auth()->user()->likes()->where('artwork_id', $artwork->id)->first();

        if (!$like) {
            return back()->with('info', 'You haven\'t liked this artwork.');
        }

        $like->delete();

        $artwork->decrementLikes();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'likes_count' => $artwork->fresh()->likes_count,
            ]);
        }

        return back()->with('success', 'Like removed.');
    }
}