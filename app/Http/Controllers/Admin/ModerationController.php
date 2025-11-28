<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Artwork;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ModerationController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Report::class);

        $filter = $request->get('filter', 'pending');

        $query = Report::with(['reporter', 'reportable', 'reviewer']);

        switch ($filter) {
            case 'reviewed':
                $query->reviewed();
                break;
            case 'dismissed':
                $query->where('status', 'dismissed');
                break;
            default:
                $query->pending();
        }

        $reports = $query->latest()->paginate(20);

        $stats = [
            'pending_count' => Report::pending()->count(),
            'reviewed_count' => Report::reviewed()->count(),
            'dismissed_count' => Report::where('status', 'dismissed')->count(),
        ];

        return view('admin.moderation.index', compact('reports', 'filter', 'stats'));
    }

    public function show(Report $report)
    {
        $this->authorize('view', $report);

        $report->load(['reporter', 'reportable', 'reviewer']);

        return view('admin.moderation.show', compact('report'));
    }

    public function dismiss(Request $request, Report $report)
    {
        $this->authorize('review', Report::class);

        $request->validate([
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $report->update([
            'status' => 'dismissed',
            'admin_action' => $request->note ?? 'Report dismissed - no violation found',
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->route('admin.moderation.index')
            ->with('success', 'Report dismissed successfully.');
    }

    public function takeDown(Request $request, Report $report)
    {
        $this->authorize('review', Report::class);

        $request->validate([
            'action' => ['required', 'in:delete,warn'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $reportable = $report->reportable;

        if (!$reportable) {
            return back()->with('error', 'Reported content no longer exists.');
        }

        if ($request->action === 'delete') {
            if ($reportable instanceof Artwork) {
                Storage::disk('public')->delete($reportable->image_path);
                $reportable->delete();
                $actionText = 'Artwork deleted';
            } elseif ($reportable instanceof Comment) {
                $reportable->delete();
                $actionText = 'Comment deleted';
            } else {
                $actionText = 'Content removed';
            }

        } else {
            $actionText = 'User warned - ' . ($request->note ?? 'Content flagged for review');

        }

        $report->update([
            'status' => 'reviewed',
            'admin_action' => $actionText,
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->route('admin.moderation.index')
            ->with('success', 'Action taken successfully. ' . $actionText . ' 🛡️');
    }
}