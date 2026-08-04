<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'description', 'slug'];

    protected $fillable = [
        'title', 'description', 'slug', 'client', 'field', 'year', 'image', 'is_featured', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function experts(): BelongsToMany
    {
        return $this->belongsToMany(Expert::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $locale = app()->getLocale();

        return static::published()
            ->where("slug->{$locale}", $value)
            ->firstOrFail();
    }
}
