<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($artworkId)
    {
        $artwork = Artwork::findOrFail($artworkId);

        $existingLike = Like::where('user_id', Auth::id())
            ->where('artwork_id', $artworkId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $message = 'Artwork removed from likes';
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'artwork_id' => $artworkId,
            ]);
            $message = 'Artwork liked!';
        }

        return back()->with('success', $message);
    }
}