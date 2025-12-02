<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\ChallengeEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChallengeManagementController extends Controller
{
    use AuthorizesRequests;

    public function myChallenges()
    {
        $challenges = Challenge::where('curator_id', auth()->id())
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->withCount('entries')
            ->latest()
            ->paginate(12);

        return view('curator.challenges.index', compact('challenges'));
    }

    public function create()
    {
        $this->authorize('create', Challenge::class);

        return view('curator.challenges.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Challenge::class);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'rules' => ['nullable', 'string', 'max:2000'],
            'prizes' => ['nullable', 'string', 'max:1000'],
            'banner_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:3072'], // 3MB
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'status' => ['required', 'in:draft,active'],
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('challenges', 'public');
        }

        $challenge = Challenge::create([
            'curator_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'rules' => $validated['rules'],
            'prizes' => $validated['prizes'],
            'banner_image' => $validated['banner_image'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('curator.challenges.mine')
            ->with('success', 'Challenge created successfully!');
    }

    public function edit(Challenge $challenge)
    {
        $this->authorize('update', $challenge);

        return view('curator.challenges.edit', compact('challenge'));
    }

    public function update(Request $request, Challenge $challenge)
    {
        $this->authorize('update', $challenge);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'rules' => ['nullable', 'string', 'max:2000'],
            'prizes' => ['nullable', 'string', 'max:1000'],
            'banner_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:3072'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'status' => ['required', 'in:draft,active,ended'],
        ]);

        if ($request->hasFile('banner_image')) {
            if ($challenge->banner_image) {
                Storage::disk('public')->delete($challenge->banner_image);
            }

            $validated['banner_image'] = $request->file('banner_image')->store('challenges', 'public');
        }

        $challenge->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'rules' => $validated['rules'],
            'prizes' => $validated['prizes'],
            'banner_image' => $validated['banner_image'] ?? $challenge->banner_image,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('curator.challenges.mine')
            ->with('success', 'Challenge updated successfully! ✨');
    }

    public function destroy(Challenge $challenge)
    {
        $this->authorize('delete', $challenge);

        if ($challenge->banner_image) {
            Storage::disk('public')->delete($challenge->banner_image);
        }

        $challenge->delete();

        return redirect()->route('curator.challenges.mine')
            ->with('success', 'Challenge deleted successfully.');
    }

    public function entries(Challenge $challenge)
    {
        $this->authorize('update', $challenge);

        $entries = $challenge->entries()
            ->with(['artwork.user', 'artwork.category', 'artwork.tags', 'user'])
            ->latest()
            ->paginate(24);

        $stats = [
            'total_entries' => $challenge->entries()->count(),
            'unique_participants' => $challenge->entries()->distinct('user_id')->count('user_id'),
            'winners_selected' => $challenge->entries()->where('is_winner', true)->count(),
        ];

        return view('curator.challenges.entries', compact('challenge', 'entries', 'stats'));
    }

    public function selectWinner(Challenge $challenge, ChallengeEntry $entry)
    {
        $this->authorize('selectWinner', $challenge);

        if ($entry->challenge_id !== $challenge->id) {
            abort(404);
        }

        if ($entry->is_winner) {
            return back()->with('info', 'This entry is already marked as a winner.');
        }

        $entry->update(['is_winner' => true]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Winner selected successfully! 🏆',
            ]);
        }

        return back()->with('success', 'Winner selected successfully! 🏆');
    }

    public function removeWinner(Challenge $challenge, ChallengeEntry $entry)
    {
        $this->authorize('selectWinner', $challenge);

        if ($entry->challenge_id !== $challenge->id) {
            abort(404);
        }

        $entry->update(['is_winner' => false]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Winner status removed.',
            ]);
        }

        return back()->with('success', 'Winner status removed.');
    }
}