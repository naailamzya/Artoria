<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    public function show($id)
    {
        $artwork = Artwork::with('user', 'category', 'comments.user', 'likes', 'favorites')
            ->findOrFail($id);

        $hasLiked = false;
        if (Auth::check()) {
            $hasLiked = $artwork->likes()
                ->where('user_id', Auth::id())
                ->exists();
        }

        $hasFavorited = false;
        if (Auth::check()) {
            $hasFavorited = $artwork->favorites()
                ->where('user_id', Auth::id())
                ->exists();
        }

        return view('artworks.show', compact('artwork', 'hasLiked', 'hasFavorited'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('artworks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('artworks', $filename, 'public');

        Artwork::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Artwork berhasil di-upload!');
    }

    public function edit($id)
    {
        $artwork = Artwork::findOrFail($id);

        if ($artwork->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('artworks.edit', compact('artwork', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $artwork = Artwork::findOrFail($id);

        if ($artwork->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($artwork->file_path);

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('artworks', $filename, 'public');

            $artwork->file_path = $path;
        }

        $artwork->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('artworks.show', $artwork->id)
            ->with('success', 'Artwork berhasil di-update!');
    }

    public function destroy($id)
    {
        $artwork = Artwork::findOrFail($id);

        if ($artwork->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($artwork->file_path);

        $artwork->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Artwork berhasil dihapus!');
    }
}