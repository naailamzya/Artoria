<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserManagementController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('display_name', 'like', "%{$request->search}%");
            });
        }

        $users = $query->withCount('artworks')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->load(['artworks.category', 'challenges']);

        $stats = [
            'artworks_count' => $user->artworks()->count(),
            'total_likes' => $user->artworks()->sum('likes_count'),
            'total_views' => $user->artworks()->sum('views_count'),
            'comments_count' => $user->comments()->count(),
            'challenges_created' => $user->challenges()->count(),
            'challenge_submissions' => $user->challengeEntries()->count(),
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function suspend(User $user)
    {
        $this->authorize('manageStatus', $user);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        $user->update(['status' => 'suspended']);

        return back()->with('success', 'User suspended successfully.');
    }

    public function activate(User $user)
    {
        $this->authorize('manageStatus', $user);

        $user->update(['status' => 'active']);

        return back()->with('success', 'User activated successfully. ✅');
    }

    public function pendingCurators()
    {
        $this->authorize('approveCurator', User::class);

        $pendingCurators = User::where('role', 'curator')
            ->where('status', 'pending')
            ->withCount('artworks')
            ->latest()
            ->paginate(20);

        return view('admin.curators.pending', compact('pendingCurators'));
    }

    public function approveCurator(User $user)
    {
        $this->authorize('approveCurator', User::class);

        if ($user->role !== 'curator') {
            return back()->with('error', 'User is not a curator.');
        }

        if ($user->status !== 'pending') {
            return back()->with('error', 'Curator is not pending approval.');
        }

        $user->update(['status' => 'active']);

        return back()->with('success', 'Curator approved successfully!');
    }

    public function rejectCurator(User $user)
    {
        $this->authorize('approveCurator', User::class);

        if ($user->role !== 'curator') {
            return back()->with('error', 'User is not a curator.');
        }

        if ($user->status !== 'pending') {
            return back()->with('error', 'Curator is not pending approval.');
        }

        $user->update([
            'role' => 'member',
            'status' => 'active',
        ]);

        return back()->with('success', 'Curator application rejected.');
    }
}