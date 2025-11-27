<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a new comment
     */
    public function store(Request $request, Artwork $artwork)
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validate([
            'content' => ['required', 'string', 'min:2', 'max:500'],
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'artwork_id' => $artwork->id,
            'content' => $validated['content'],
        ]);

        $comment->load('user');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'comment' => $comment,
                'html' => view('components.comment-item', compact('comment'))->render(),
            ]);
        }

        return back()->with('success', 'Comment posted!');
    }

    /**
     * Update the specified comment
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => ['required', 'string', 'min:2', 'max:500'],
        ]);

        $comment->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'comment' => $comment,
            ]);
        }

        return back()->with('success', 'Comment updated!');
    }

    /**
     * Remove the specified comment
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment deleted',
            ]);
        }

        return back()->with('success', 'Comment deleted.');
    }
}