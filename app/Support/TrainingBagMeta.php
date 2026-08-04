<?php

namespace App\Support;

use App\Models\TrainingBag;

class TrainingBagMeta
{
    public static function migrateLegacy(TrainingBag $bag): array
    {
        $items = [];

        if ($bag->duration_days) {
            $items[] = [
                'ar' => $bag->duration_days.' يوم',
                'en' => $bag->duration_days.' days',
            ];
        }

        if ($bag->duration_hours) {
            $items[] = [
                'ar' => $bag->duration_hours.' ساعة',
                'en' => $bag->duration_hours.' hours',
            ];
        }

        if (filled($bag->type)) {
            $items[] = [
                'ar' => in_array($bag->type, ['ready', 'custom'], true)
                    ? __('training_bags.'.$bag->type, [], 'ar')
                    : $bag->type,
                'en' => in_array($bag->type, ['ready', 'custom'], true)
                    ? __('training_bags.'.$bag->type, [], 'en')
                    : $bag->type,
            ];
        }

        if ($bag->slides_count) {
            $items[] = [
                'ar' => $bag->slides_count.' شريحة',
                'en' => $bag->slides_count.' slides',
            ];
        }

        return $items;
    }

    /**
     * @return array<int, string>
     */
    public static function labels(TrainingBag $bag, ?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        if (! empty($bag->meta_highlights)) {
            return collect($bag->meta_highlights)
                ->map(fn ($item) => TrainingBagSections::localized(is_array($item) ? $item : ['ar' => (string) $item], $locale))
                ->filter()
                ->values()
                ->all();
        }

        return collect(self::migrateLegacy($bag))
            ->map(fn ($item) => TrainingBagSections::localized($item, $locale))
            ->filter()
            ->values()
            ->all();
    }
}
