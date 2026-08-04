<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableSlug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TrainingActivity extends Model
{
    use HasTranslatableSlug, HasTranslations;

    public array $translatable = ['title', 'slug', 'excerpt', 'content'];

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'image', 'pdf_path', 'word_path',
        'sort_order', 'is_published',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return static::published()->whereKey($value)->firstOrFail();
    }
}
