<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $artworkId)
    {
        $artwork = Artwork::findOrFail($artworkId);

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'artwork_id' => $artworkId,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comment posted!');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted!');
    }
}