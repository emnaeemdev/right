<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'description', 'slug'];

    protected $fillable = [
        'title', 'description', 'slug', 'icon', 'sort_order', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $locale = app()->getLocale();

        return static::published()
            ->where("slug->{$locale}", $value)
            ->firstOrFail();
    }
}
