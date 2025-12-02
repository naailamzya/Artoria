<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Artwork;
use App\Models\ChallengeEntry;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $filter = $request->get('filter', 'active');

        $query = Challenge::with(['curator'])->withCount('artworks');

        switch ($filter) {
            case 'upcoming':
                $query->where('start_date', '>', now());
                break;
            case 'ended':
                $query->where('end_date', '<', now());
                break;
            default:
                $query->where('start_date', '<=', now())
                      ->where('end_date', '>', now());
        }

        $challenges = $query->latest()->paginate(12);

        return view('challenges.index', compact('challenges', 'filter'));
    }

    public function show(Challenge $challenge)
    {
        $challenge->load(['curator']);

        $winners = $challenge->artworks()
            ->wherePivot('is_winner', true)
            ->with(['user', 'category'])
            ->get();

        $entries = $challenge->artworks()
            ->with(['user', 'category'])
            ->paginate(24);

        $hasSubmitted = false;
        $userEntries = collect();

        if (Auth::check()) {
            $userEntries = $challenge->artworks()
                ->where('artworks.user_id', Auth::id())
                ->with(['user', 'category'])
                ->get();
            $hasSubmitted = $userEntries->count() > 0;
        }

        return view('challenges.show', compact(
            'challenge',
            'winners',
            'entries',
            'hasSubmitted',
            'userEntries' 
        ));
    }

 public function submit(Request $request, Challenge $challenge)
{
    \Log::info('Challenge submit called', [
        'user_id' => auth()->id(),
        'user_status' => auth()->user()->status ?? 'none',
        'challenge_id' => $challenge->id,
        'artwork_id' => $request->artwork_id,
        'request_data' => $request->all()
    ]);

    if (!$challenge->isActive()) {
        return redirect()->back()
            ->with('error', 'This challenge is not active anymore.');
    }

    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login')
            ->with('error', 'Please login to submit your artwork.');
    }

    $request->validate([
        'artwork_id' => [
            'required',
            'exists:artworks,id',
            function ($attribute, $value, $fail) use ($user) {
                $artwork = Artwork::find($value);
                if (!$artwork || $artwork->user_id !== $user->id) {
                    $fail('You can only submit your own artwork.');
                }
            },
            function ($attribute, $value, $fail) use ($challenge) {
                $existingEntry = ChallengeEntry::where([
                    'challenge_id' => $challenge->id,
                    'artwork_id' => $value
                ])->first();
                
                if ($existingEntry) {
                    $fail('This artwork is already submitted to this challenge.');
                }
            }
        ]
    ]);

    ChallengeEntry::create([
        'challenge_id' => $challenge->id,
        'artwork_id' => $request->artwork_id,
        'user_id' => $user->id,
        'submitted_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Your artwork has been successfully submitted to the challenge!');
}

    public function mySubmissions()
    {
        $submissions = ChallengeEntry::with([
            'challenge:id,title,start_date,end_date',
            'artwork:id,title,image_path,user_id',
            'artwork.user:id,display_name'
        ])
        ->where('user_id', Auth::id())
        ->withPivot('is_winner', 'submitted_at')
        ->latest()
        ->paginate(12);

        return view('challenges.my-submissions', compact('submissions'));
    }

    public function adminIndex()
    {
        $challenges = Challenge::with(['curator'])
            ->withCount('artworks')
            ->latest()
            ->paginate(20);

        return view('admin.challenges.index', compact('challenges'));
    }
}