<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Expert extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'title', 'bio', 'specializations'];

    protected $fillable = [
        'name', 'title', 'bio', 'specializations', 'photo', 'email', 'sort_order', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }
}
