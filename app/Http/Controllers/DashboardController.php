<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $myArtworks = Artwork::where('user_id', $user->id)
            ->with('category', 'likes', 'comments')
            ->latest()
            ->get();

        $totalArtworks = $myArtworks->count();
        $totalLikes = $myArtworks->sum(function($artwork) {
            return $artwork->likes->count();
        });
        $totalComments = $myArtworks->sum(function($artwork) {
            return $artwork->comments->count();
        });

        return view('dashboard', compact('myArtworks', 'totalArtworks', 'totalLikes', 'totalComments'));
    }
}