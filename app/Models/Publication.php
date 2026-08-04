<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableSlug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Publication extends Model
{
    use HasTranslatableSlug, HasTranslations;

    public array $translatable = ['title', 'description', 'slug', 'excerpt', 'content'];

    protected $fillable = [
        'title', 'description', 'slug', 'excerpt', 'content', 'image',
        'category', 'pdf_path', 'word_path', 'year', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderByDesc('year');
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return static::published()->whereKey($value)->firstOrFail();
    }
}
