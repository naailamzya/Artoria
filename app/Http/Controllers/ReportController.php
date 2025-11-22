<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function create($artworkId)
    {
        $artwork = Artwork::findOrFail($artworkId);
        return view('reports.create', compact('artwork'));
    }

    public function store(Request $request, $artworkId)
    {
        $artwork = Artwork::findOrFail($artworkId);

        $request->validate([
            'reason' => 'required|in:SARA,Plagiat,Konten Tidak Pantas,Spam,Lainnya',
            'description' => 'required|string|max:1000',
        ]);

        Report::create([
            'user_id' => Auth::id(),
            'artwork_id' => $artworkId,
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('artworks.show', $artworkId)
            ->with('success', 'Report submitted. Admin will review it.');
    }
}