<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ArtworkController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of artworks
     */
    public function index(Request $request)
    {
        $query = Artwork::with(['user', 'category', 'tags']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->popular();
                break;
            case 'views':
                $query->orderBy('views_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $artworks = $query->paginate(24);
        $categories = Category::all();

        return view('artworks.index', compact('artworks', 'categories', 'sort'));
    }

    /**
     * Display the specified artwork
     */
    public function show(Artwork $artwork)
    {
        $artwork->incrementViews();

        $artwork->load(['user', 'category', 'tags', 'comments.user', 'challenges']);

        $hasLiked = false;
        $hasFavorited = false;

        if (auth()->check()) {
            $hasLiked = auth()->user()->hasLiked($artwork);
            $hasFavorited = auth()->user()->hasFavorited($artwork);
        }

        $relatedArtworks = Artwork::with(['user', 'category'])
            ->where('id', '!=', $artwork->id)
            ->where(function ($query) use ($artwork) {
                $query->where('category_id', $artwork->category_id)
                    ->orWhereHas('tags', function ($q) use ($artwork) {
                        $q->whereIn('tags.id', $artwork->tags->pluck('id'));
                    });
            })
            ->limit(6)
            ->get();

        return view('artworks.show', compact(
            'artwork',
            'hasLiked',
            'hasFavorited',
            'relatedArtworks'
        ));
    }

    /**
     * Show the form for creating a new artwork
     */
    public function create()
    {
        $this->authorize('create', Artwork::class);

        $categories = Category::all();
        $popularTags = Tag::popular(30)->get();

        return view('artworks.create', compact('categories', 'popularTags'));
    }

    /**
     * Store a newly created artwork
     */
    public function store(Request $request)
    {
        $this->authorize('create', Artwork::class);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'], // 5MB
            'tags' => ['nullable', 'string', 'max:500'],
        ]);

        $imagePath = $request->file('image')->store('artworks', 'public');

        $artwork = Artwork::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_path' => $imagePath,
        ]);

        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $artwork->syncTags($tagNames);
        }

        return redirect()->route('artworks.show', $artwork)
            ->with('success', 'Artwork uploaded successfully! 🎨');
    }

    /**
     * Show the form for editing the artwork
     */
    public function edit(Artwork $artwork)
    {
        $this->authorize('update', $artwork);

        $categories = Category::all();
        $popularTags = Tag::popular(30)->get();
        $artwork->load('tags');

        return view('artworks.edit', compact('artwork', 'categories', 'popularTags'));
    }

    /**
     * Update the specified artwork
     */
    public function update(Request $request, Artwork $artwork)
    {
        $this->authorize('update', $artwork);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'tags' => ['nullable', 'string', 'max:500'],
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($artwork->image_path);

            $validated['image_path'] = $request->file('image')->store('artworks', 'public');
        }

        $artwork->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'image_path' => $validated['image_path'] ?? $artwork->image_path,
        ]);

        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $artwork->syncTags($tagNames);
        } else {
            $artwork->syncTags([]);
        }

        return redirect()->route('artworks.show', $artwork)
            ->with('success', 'Artwork updated successfully! ✨');
    }

    /**
     * Remove the specified artwork
     */
    public function destroy(Artwork $artwork)
    {
        $this->authorize('delete', $artwork);

        Storage::disk('public')->delete($artwork->image_path);

        $artwork->delete();

        return redirect()->route('artworks.mine')
            ->with('success', 'Artwork deleted successfully.');
    }

    /**
     * Display user's own artworks
     */
    public function myArtworks()
    {
        $artworks = Artwork::with(['category', 'tags'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(24);

        return view('artworks.mine', compact('artworks'));
    }

    /**
     * Filter artworks by category
     */
    public function byCategory(Category $category)
    {
        $artworks = Artwork::with(['user', 'category', 'tags'])
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(24);

        return view('artworks.by-category', compact('artworks', 'category'));
    }

    /**
     * Filter artworks by tag
     */
    public function byTag(Tag $tag)
    {
        $artworks = $tag->artworks()
            ->with(['user', 'category', 'tags'])
            ->latest()
            ->paginate(24);

        return view('artworks.by-tag', compact('artworks', 'tag'));
    }

    /**
     * Search artworks
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (empty($query)) {
            return redirect()->route('artworks.index');
        }

        $artworks = Artwork::with(['user', 'category', 'tags'])
            ->search($query)
            ->latest()
            ->paginate(24);

        return view('artworks.search', compact('artworks', 'query'));
    }

    /**
     * Get artwork stats (AJAX)
     */
    public function stats(Artwork $artwork)
    {
        return response()->json([
            'likes_count' => $artwork->likes_count,
            'views_count' => $artwork->views_count,
            'comments_count' => $artwork->comments()->count(),
            'favorites_count' => $artwork->favorites()->count(),
        ]);
    }
}