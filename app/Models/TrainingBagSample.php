<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class TrainingBagSample extends Model
{
    use HasTranslations;

    public array $translatable = ['title'];

    protected $fillable = [
        'training_bag_id', 'type', 'title', 'video_url', 'activity_html', 'pdf_path', 'is_public',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    public function trainingBag(): BelongsTo
    {
        return $this->belongsTo(TrainingBag::class);
    }

    public function displayTitle(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $fallback = $locale === 'ar' ? 'en' : 'ar';

        $title = trim((string) ($this->getTranslation('title', $locale, false)
            ?: $this->getTranslation('title', $fallback, false)));

        if ($title !== '') {
            return $title;
        }

        return match ($this->type) {
            'video' => __('training_bags.video_sample'),
            'activity' => __('training_bags.activity_sample'),
            'pdf' => __('training_bags.pdf_sample'),
            default => __('training_bags.sample'),
        };
    }
}
