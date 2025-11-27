<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'usage_count',
    ];

    protected function casts(): array
    {
        return [
            'usage_count' => 'integer',
        ];
    }

    public function artworks()
    {
        return $this->belongsToMany(Artwork::class, 'artwork_tag')
                    ->withTimestamps();
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function scopePopular($query, $limit = 20)
    {
        return $query->orderBy('usage_count', 'desc')->limit($limit);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }

    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    public function decrementUsage()
    {
        if ($this->usage_count > 0) {
            $this->decrement('usage_count');
        }
    }

    public static function findOrCreateFromArray(array $tagNames): array
    {
        $tags = [];
        
        foreach ($tagNames as $tagName) {
            $tagName = trim($tagName);
            
            if (empty($tagName)) {
                continue;
            }
            
            $tag = static::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                ['name' => $tagName]
            );
            
            $tags[] = $tag->id;
        }
        
        return $tags;
    }
}