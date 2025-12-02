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
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->withCount('likes')->orderBy('likes_count', 'desc');
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
        $artwork->increment('views_count');
        
        $artwork->load(['user', 'category', 'tags', 'comments.user', 'challenges']);

        $hasLiked = false;
        $hasFavorited = false;

        if (auth()->check()) {
            $user = auth()->user();
            $hasLiked = $user->likes()->where('artwork_id', $artwork->id)->exists();
            $hasFavorited = $user->favorites()->where('artwork_id', $artwork->id)->exists();
        }

        $relatedArtworks = Artwork::with(['user', 'category'])
            ->where('id', '!=', $artwork->id)
            ->where(function ($query) use ($artwork) {
                $query->where('category_id', $artwork->category_id)
                    ->orWhereHas('tags', function ($q) use ($artwork) {
                        $q->whereIn('tags.id', $artwork->tags->pluck('id'));
                    });
            })
            ->latest()
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
    \Log::info('ArtworkController@create method reached', [
        'user_id' => auth()->id(),
        'user_status' => auth()->user()->status ?? 'none',
        'user_role' => auth()->user()->role ?? 'none',
    ]);
    
    try {
        $this->authorize('create', Artwork::class);
        \Log::info('Authorization passed');
    } catch (\Exception $e) {
        \Log::error('Authorization failed', ['error' => $e->getMessage()]);
        throw $e;
    }

    $categories = Category::all();
    $popularTags = Tag::limit(30)->get();

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
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
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
            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $artwork->tags()->attach($tag->id);
            }
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
        $popularTags = Tag::limit(30)->get();
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

        $updateData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($artwork->image_path && Storage::disk('public')->exists($artwork->image_path)) {
                Storage::disk('public')->delete($artwork->image_path);
            }
            
            // Store new image
            $updateData['image_path'] = $request->file('image')->store('artworks', 'public');
        }

        $artwork->update($updateData);

        // Update tags
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $artwork->tags()->sync($tagIds);
        } else {
            $artwork->tags()->detach();
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

        // Delete image file
        if ($artwork->image_path && Storage::disk('public')->exists($artwork->image_path)) {
            Storage::disk('public')->delete($artwork->image_path);
        }

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
            ->where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
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
            'likes_count' => $artwork->likes()->count(),
            'views_count' => $artwork->views_count,
            'comments_count' => $artwork->comments()->count(),
            'favorites_count' => $artwork->favorites()->count(),
        ]);
    }

    /**
     * Admin: List all artworks
     */
    public function adminIndex()
    {
        $artworks = Artwork::with(['user', 'category'])
            ->withCount(['likes', 'comments', 'favorites'])
            ->latest()
            ->paginate(20);
        
        return view('admin.artworks.index', compact('artworks'));
    }

    /**
     * Admin: Permanently delete artwork
     */
    public function forceDelete(Artwork $artwork)
    {
        $this->authorize('forceDelete', $artwork);
        
        // Delete image
        if ($artwork->image_path && Storage::disk('public')->exists($artwork->image_path)) {
            Storage::disk('public')->delete($artwork->image_path);
        }
        
        // Force delete
        $artwork->forceDelete();
        
        return back()->with('success', 'Artwork permanently deleted.');
    }
}