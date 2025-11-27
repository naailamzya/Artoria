<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $tags = Tag::where('name', 'like', "%{$query}%")
            ->orderBy('usage_count', 'desc')
            ->limit(10)
            ->get(['id', 'name', 'slug']);

        return response()->json($tags);
    }

    public function popular()
    {
        $tags = Tag::popular(30)->get(['id', 'name', 'slug', 'usage_count']);

        return response()->json($tags);
    }
}