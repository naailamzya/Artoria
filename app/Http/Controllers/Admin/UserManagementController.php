<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $user->load(['artworks' => function($query) {
            $query->latest()->take(6);
        }]);

        $stats = [
            'artworks_count' => $user->artworks()->count(),
            'likes_received' => $user->artworks()->sum('likes_count'),
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
        
        $rejectedCount = 0;

        return view('admin.curators.pending', compact('pendingCurators', 'approvedCount', 'rejectedCount'));
    }

    public function approveCurator(User $user)
    {
        if ($user->role !== 'curator' || $user->status !== 'pending') {
            return redirect()->back()->with('error', 'Invalid curator application.');
        }

        $user->update(['status' => 'active']);
        
        Log::info(' Curator approved', [
            'user_id' => $user->id,
            'name' => $user->name,
            'by_admin' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 
            "🎨 Curator <strong>{$user->name}</strong> has been approved! They can now create challenges."
        );
    }

    public function rejectCurator(User $user)
    {
        if ($user->role !== 'curator' || $user->status !== 'pending') {
            return redirect()->back()->with('error', 'Invalid curator application.');
        }

        $userName = $user->name;
        $userEmail = $user->email;

        $user->delete();
        
        Log::warning('🗑️ Curator rejected and deleted', [
            'user_id' => $user->id,
            'name' => $userName,
            'email' => $userEmail,
            'by_admin' => auth()->id(),
        ]);

        return redirect()->back()->with('warning', 
            "🗑️ Curator <strong>{$userName}</strong> has been rejected and account deleted. " .
            "They must register again to apply."
        );
    }

    public function suspend(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot suspend yourself.');
        }

        $oldStatus = $user->status;
        $user->update(['status' => 'suspended']);
        
        Log::warning('🚫 User suspended', [
            'user_id' => $user->id,
            'name' => $user->name,
            'old_status' => $oldStatus,
            'new_status' => 'suspended',
            'by_admin' => auth()->id(),
        ]);

        return redirect()->back()->with('warning', 
            "🚫 User <strong>{$user->name}</strong> has been suspended. They cannot login until activated."
        );
    }

    public function activate(User $user)
    {
        $oldStatus = $user->status;
        $user->update(['status' => 'active']);
        
        Log::info('✅ User activated', [
            'user_id' => $user->id,
            'name' => $user->name,
            'old_status' => $oldStatus,
            'new_status' => 'active',
            'by_admin' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 
            "✅ User <strong>{$user->name}</strong> has been activated."
        );
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        $userName = $user->name;
        $user->delete(); // Hard delete
        
        Log::warning('🗑️ User permanently deleted', [
            'user_id' => $user->id,
            'name' => $userName,
            'by_admin' => auth()->id(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('warning', "🗑️ User <strong>{$userName}</strong> has been permanently deleted.");
    }

    public function deletedUsers()
    {
        $deletedUsers = collect(); // Empty collection
        
        return view('admin.users.deleted', compact('deletedUsers'));
    }

    public function restoreUser($id)
    {
        return redirect()->back()->with('error', 'Restore functionality not available without soft deletes.');
    }
}