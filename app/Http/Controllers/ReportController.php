<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Comment;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReportController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display user's reports
     */
    public function myReports()
    {
        $reports = Report::with(['reportable'])
            ->where('reporter_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('reports.mine', compact('reports'));
    }

    /**
     * Report an artwork
     */
    public function reportArtwork(Request $request, Artwork $artwork)
    {
        $this->authorize('report', $artwork);

        $validated = $request->validate([
            'reason' => ['required', 'string', 'min:10', 'max:500'],
        ]);

        $existingReport = Report::where('reporter_id', auth()->id())
            ->where('reportable_type', Artwork::class)
            ->where('reportable_id', $artwork->id)
            ->where('status', 'pending')
            ->first();

        if ($existingReport) {
            return back()->with('info', 'You have already reported this artwork.');
        }

        Report::create([
            'reporter_id' => auth()->id(),
            'reportable_type' => Artwork::class,
            'reportable_id' => $artwork->id,
            'reason' => $validated['reason'],
        ]);

        return back()->with('success', 'Report submitted. Our team will review it soon.');
    }

    /**
     * Report a comment
     */
    public function reportComment(Request $request, Comment $comment)
    {
        $this->authorize('report', $comment);

        $validated = $request->validate([
            'reason' => ['required', 'string', 'min:10', 'max:500'],
        ]);

        $existingReport = Report::where('reporter_id', auth()->id())
            ->where('reportable_type', Comment::class)
            ->where('reportable_id', $comment->id)
            ->where('status', 'pending')
            ->first();

        if ($existingReport) {
            return back()->with('info', 'You have already reported this comment.');
        }

        Report::create([
            'reporter_id' => auth()->id(),
            'reportable_type' => Comment::class,
            'reportable_id' => $comment->id,
            'reason' => $validated['reason'],
        ]);

        return back()->with('success', 'Report submitted. Our team will review it soon.');
    }
}