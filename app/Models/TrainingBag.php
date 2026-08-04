<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableSlug;
use App\Support\TextLines;
use App\Support\TrainingBagMeta;
use App\Support\TrainingBagSections;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class TrainingBag extends Model implements HasMedia
{
    use HasTranslatableSlug, HasTranslations, InteractsWithMedia;

    public array $translatable = [
        'title', 'description', 'slug', 'contents',
        'general_objective', 'detailed_objectives', 'target_audience',
    ];

    protected $fillable = [
        'title', 'description', 'slug', 'image', 'field',
        'duration_days', 'duration_hours', 'type', 'slides_count',
        'contents', 'general_objective', 'detailed_objectives',
        'target_audience', 'included_files', 'content_sections', 'meta_highlights',
        'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'included_files' => 'array',
            'content_sections' => 'array',
            'meta_highlights' => 'array',
        ];
    }

    public function cycleSteps(): HasMany
    {
        return $this->hasMany(TrainingBagCycleStep::class)->orderBy('sort_order');
    }

    public function samples(): HasMany
    {
        return $this->hasMany(TrainingBagSample::class);
    }

    public function quoteRequests(): HasMany
    {
        return $this->hasMany(QuoteRequest::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }

    public function typeLabel(?string $locale = null): ?string
    {
        if (! filled($this->type)) {
            return null;
        }

        $locale = $locale ?? app()->getLocale();
        $key = 'training_bags.'.$this->type;
        $translated = __($key, [], $locale);

        return $translated !== $key ? $translated : $this->type;
    }

    /**
     * @return array<int, string>
     */
    public function metaHighlightLabels(?string $locale = null): array
    {
        return TrainingBagMeta::labels($this, $locale);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return static::published()->whereKey($value)->firstOrFail();
    }

    /**
     * @return array<int, array{type: string, title: string, body: string, items: array<int, string>}>
     */
    public function displaySections(?string $locale = null): array
    {
        $sections = TrainingBagSections::forDisplay($this, $locale);

        if ($sections !== []) {
            return $sections;
        }

        return TrainingBagSections::forDisplay(
            tap(clone $this, fn (TrainingBag $legacy) => $legacy->forceFill([
                'content_sections' => TrainingBagSections::migrateLegacyBag($this),
            ])),
            $locale,
        );
    }

    public function includedFileLabels(?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        return collect($this->included_files ?? [])
            ->map(fn ($item) => is_array($item)
                ? ($item[$locale] ?? $item['ar'] ?? $item['en'] ?? null)
                : $item)
            ->filter()
            ->values()
            ->all();
    }

    public function detailedObjectivesList(?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        $text = $this->getTranslation('detailed_objectives', $locale)
            ?: $this->getTranslation('detailed_objectives', $locale === 'ar' ? 'en' : 'ar');

        return TextLines::from($text);
    }

    public function targetAudienceList(?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        $text = $this->getTranslation('target_audience', $locale)
            ?: $this->getTranslation('target_audience', $locale === 'ar' ? 'en' : 'ar');

        return TextLines::from($text);
    }
}
