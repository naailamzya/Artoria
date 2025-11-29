<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Artwork;
use App\Models\ChallengeEntry;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChallengeController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $filter = $request->get('filter', 'active');

        $query = Challenge::with(['curator'])
            ->withCount('entries');

        switch ($filter) {
            case 'upcoming':
                $query->upcoming();
                break;
            case 'ended':
                $query->ended();
                break;
            default:
                $query->active();
        }

        $challenges = $query->latest()->paginate(12);

        return view('challenges.index', compact('challenges', 'filter'));
    }

    public function show(Challenge $challenge)
    {
        $challenge->load(['curator', 'entries.artwork.user', 'entries.artwork.category']);

        $winners = $challenge->entries()
            ->where('is_winner', true)
            ->with(['artwork.user', 'artwork.category', 'artwork.tags'])
            ->get();

        $entries = $challenge->entries()
            ->with(['artwork.user', 'artwork.category', 'artwork.tags'])
            ->latest()
            ->paginate(24);

        $hasSubmitted = false;
        $userEntry = null;

        if (auth()->check()) {
            $userEntry = $challenge->entries()
                ->where('user_id', auth()->id())
                ->first();
            $hasSubmitted = (bool) $userEntry;
        }

        return view('challenges.show', compact(
            'challenge',
            'winners',
            'entries',
            'hasSubmitted',
            'userEntry'
        ));
    }

    public function submit(Request $request, Challenge $challenge)
    {
        $this->authorize('submit', $challenge);

        $validated = $request->validate([
            'artwork_id' => ['required', 'exists:artworks,id'],
        ]);

        $artwork = Artwork::findOrFail($validated['artwork_id']);

        if ($artwork->user_id !== auth()->id()) {
            abort(403, 'You can only submit your own artworks.');
        }

        $existingEntry = ChallengeEntry::where('challenge_id', $challenge->id)
            ->where('artwork_id', $artwork->id)
            ->first();

        if ($existingEntry) {
            return back()->with('error', 'This artwork has already been submitted to this challenge.');
        }

        ChallengeEntry::create([
            'challenge_id' => $challenge->id,
            'artwork_id' => $artwork->id,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Artwork submitted to challenge successfully! 🎨');
    }

    public function mySubmissions()
    {
        $submissions = ChallengeEntry::with(['challenge.curator', 'artwork.category'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('challenges.my-submissions', compact('submissions'));
    }
}