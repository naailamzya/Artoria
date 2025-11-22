<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Challenge;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $artworks = Artwork::with('user', 'category')
            ->latest()
            ->take(12)
            ->get();

        $categories = Category::all();

        $activeChallenge = Challenge::where('status', 'active')
            ->latest()
            ->first();

        return view('home', compact('artworks', 'categories', 'activeChallenge'));
    }

    public function filterByCategory($categoryId)
    {
        $artworks = Artwork::with('user', 'category')
            ->where('category_id', $categoryId)
            ->latest()
            ->paginate(12);

        $categories = Category::all();
        $selectedCategory = Category::find($categoryId);

        return view('home', compact('artworks', 'categories', 'selectedCategory'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $artworks = Artwork::with('user', 'category')
            ->where('title', 'like', "%{$keyword}%")
            ->orWhereHas('user', function($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->latest()
            ->paginate(12);

        $categories = Category::all();

        return view('home', compact('artworks', 'categories', 'keyword'));
    }
}