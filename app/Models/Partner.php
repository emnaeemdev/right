<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Partner extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $fillable = [
        'name', 'logo', 'category', 'website', 'sort_order', 'is_published',
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
}
