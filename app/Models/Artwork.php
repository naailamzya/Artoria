<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image_path',
        'likes_count',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'likes_count' => 'integer',
            'views_count' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function challengeEntries()
    {
        return $this->hasMany(ChallengeEntry::class);
    }

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class, 'challenge_entries')
                    ->withTimestamps()
                    ->withPivot('is_winner');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'artwork_tag')
                    ->withTimestamps();
    }

    public function scopePopular($query)
    {
        return $query->orderBy('likes_count', 'desc');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeFeatured($query)
    {
        return $query->where('likes_count', '>=', 10)
                     ->orderBy('likes_count', 'desc');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    public function scopeWithTag($query, $tagSlug)
    {
        return $query->whereHas('tags', function($q) use ($tagSlug) {
            $q->where('slug', $tagSlug);
        });
    }

    public function scopeWithAnyTag($query, array $tagSlugs)
    {
        return $query->whereHas('tags', function($q) use ($tagSlugs) {
            $q->whereIn('slug', $tagSlugs);
        });
    }


    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementLikes()
    {
        $this->increment('likes_count');
    }

    public function decrementLikes()
    {
        $this->decrement('likes_count');
    }

    public function syncTags(array $tagNames)
    {
        $oldTags = $this->tags;
        
        $tagIds = Tag::findOrCreateFromArray($tagNames);

        $this->tags()->sync($tagIds);

        foreach ($oldTags as $oldTag) {
            if (!in_array($oldTag->id, $tagIds)) {
                $oldTag->decrementUsage();
            }
        }
        
        foreach ($tagIds as $tagId) {
            $tag = Tag::find($tagId);
            if (!$oldTags->contains('id', $tagId)) {
                $tag->incrementUsage();
            }
        }
    }

    public function attachTags(array $tagNames)
    {
        $tagIds = Tag::findOrCreateFromArray($tagNames);
        
        foreach ($tagIds as $tagId) {
            if (!$this->tags->contains('id', $tagId)) {
                $this->tags()->attach($tagId);
                Tag::find($tagId)->incrementUsage();
            }
        }
    }

    public function detachTags(array $tagNames)
    {
        $tagIds = Tag::whereIn('name', $tagNames)->pluck('id')->toArray();
        
        $this->tags()->detach($tagIds);
        
        foreach ($tagIds as $tagId) {
            Tag::find($tagId)->decrementUsage();
        }
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    public function getFormattedTagsAttribute()
    {
        return $this->tags->pluck('name')->implode(', ');
    }

    public function getTagNamesAttribute()
    {
        return $this->tags->pluck('name')->toArray();
    }
}