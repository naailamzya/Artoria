<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->withCount('artworks');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        // ✅ Load artworks WITHOUT withCount (likes_count & views_count sudah di column)
        $user->load(['artworks' => function($query) {
            $query->latest()->take(6);
        }]);

        // Calculate stats
        $stats = [
            'artworks_count' => $user->artworks()->count(),
            'likes_received' => $user->artworks()->sum('likes_count'), // ✅ Direct sum dari column
            'profile_views' => $user->profile_views ?? 0,
            'comments_count' => $user->comments()->count(),
            'challenges_created' => $user->challenges()->count(),
            'challenge_submissions' => $user->challengeEntries()->count(),
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    public function pendingCurators()
    {
        $pendingCurators = User::where('role', 'curator')
            ->where('status', 'pending')
            ->withCount('artworks')
            ->latest()
            ->get();

        $approvedCount = User::where('role', 'curator')->where('status', 'active')->count();
        $rejectedCount = User::where('role', 'curator')->where('status', 'rejected')->count();

        return view('admin.curators.pending', compact('pendingCurators', 'approvedCount', 'rejectedCount'));
    }

    public function approveCurator(User $user)
    {
        if ($user->role !== 'curator' || $user->status !== 'pending') {
            return redirect()->back()->with('error', 'Invalid curator application.');
        }

        $user->update(['status' => 'active']);

        return redirect()->back()->with('success', "Curator {$user->name} has been approved!");
    }

    public function rejectCurator(User $user)
    {
        if ($user->role !== 'curator' || $user->status !== 'pending') {
            return redirect()->back()->with('error', 'Invalid curator application.');
        }

        $user->update(['status' => 'rejected']);

        return redirect()->back()->with('success', "Curator application for {$user->name} has been rejected.");
    }

    public function suspend(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot suspend yourself.');
        }

        $user->update(['status' => 'suspended']);

        return redirect()->back()->with('success', "User {$user->name} has been suspended.");
    }

    public function activate(User $user)
    {
        $user->update(['status' => 'active']);

        return redirect()->back()->with('success', "User {$user->name} has been activated.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "User {$user->name} has been deleted.");
    }
}