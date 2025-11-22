<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\ChallengeSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::with('curator')
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('challenges.index', compact('challenges'));
    }

    public function show($id)
    {
        $challenge = Challenge::with('curator', 'submissions.artwork.user')
            ->findOrFail($id);

        $hasSubmitted = false;
        if (Auth::check()) {
            $hasSubmitted = ChallengeSubmission::whereHas('artwork', function($query) {
                $query->where('user_id', Auth::id());
            })->where('challenge_id', $id)->exists();
        }

        return view('challenges.show', compact('challenge', 'hasSubmitted'));
    }

    public function create()
    {
        if (Auth::user()->status !== 'curator') {
            abort(403, 'Only curators can create challenges.');
        }

        return view('challenges.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->status !== 'curator') {
            abort(403, 'Only curators can create challenges.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'nullable|string',
            'reward' => 'nullable|integer',
            'deadline' => 'required|date|after:today',
        ]);

        Challenge::create([
            'curator_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'rules' => $request->rules,
            'reward' => $request->reward,
            'deadline' => $request->deadline,
            'status' => 'pending', 
        ]);

        return redirect()->route('challenges.index')
            ->with('success', 'Challenge created! Waiting for admin approval.');
    }

    public function submit(Request $request, $challengeId)
    {
        $challenge = Challenge::findOrFail($challengeId);

        $request->validate([
            'artwork_id' => 'required|exists:artworks,id',
        ]);

        $artwork = \App\Models\Artwork::findOrFail($request->artwork_id);
        if ($artwork->user_id !== Auth::id()) {
            abort(403, 'You can only submit your own artworks.');
        }

        $existingSubmission = ChallengeSubmission::where('challenge_id', $challengeId)
            ->where('artwork_id', $request->artwork_id)
            ->first();

        if ($existingSubmission) {
            return back()->with('error', 'This artwork has already been submitted.');
        }

        ChallengeSubmission::create([
            'challenge_id' => $challengeId,
            'artwork_id' => $request->artwork_id,
        ]);

        return back()->with('success', 'Artwork submitted to challenge!');
    }
}