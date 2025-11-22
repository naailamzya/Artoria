<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Challenge;
use App\Models\User;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModerationController extends Controller
{
    public function index()
    {
        $pendingReports = Report::where('status', 'pending')->count();
        $pendingChallenges = Challenge::where('status', 'pending')->count();
        $totalUsers = User::count();
        $totalArtworks = Artwork::count();

        return view('admin.dashboard', compact(
            'pendingReports',
            'pendingChallenges',
            'totalUsers',
            'totalArtworks'
        ));
    }

    public function reports()
    {
        $reports = Report::with('user', 'artwork.user')
            ->latest()
            ->paginate(20);

        return view('admin.reports', compact('reports'));
    }

    public function reviewReport(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $request->validate([
            'action' => 'required|in:dismiss,take_down',
        ]);

        if ($request->action === 'take_down') {
            $artwork = $report->artwork;
            Storage::disk('public')->delete($artwork->file_path);
            $artwork->delete();

            $report->status = 'taken_down';
        } else {
            $report->status = 'dismissed';
        }

        $report->save();

        return back()->with('success', 'Report reviewed successfully!');
    }

    public function challenges()
    {
        $challenges = Challenge::with('curator')
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('admin.challenges', compact('challenges'));
    }

    public function reviewChallenge(Request $request, $id)
    {
        $challenge = Challenge::findOrFail($id);

        $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        if ($request->action === 'approve') {
            $challenge->status = 'active';
        } else {
            $challenge->delete();
            return redirect()->route('admin.challenges')
                ->with('success', 'Challenge rejected and deleted.');
        }

        $challenge->save();

        return back()->with('success', 'Challenge approved!');
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete yourself!');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }

    public function categories()
    {
        $categories = \App\Models\Category::withCount('artworks')->get();
        return view('admin.categories', compact('categories'));
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
        ]);

        \App\Models\Category::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Category added!');
    }

    public function deleteCategory($id)
    {
        $category = \App\Models\Category::findOrFail($id);

        if ($category->artworks()->count() > 0) {
            return back()->with('error', 'Cannot delete category with artworks!');
        }

        $category->delete();

        return back()->with('success', 'Category deleted!');
    }
}