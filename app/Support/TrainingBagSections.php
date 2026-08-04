<?php

namespace App\Support;

use App\Models\TrainingBag;

class TrainingBagSections
{
    public static function migrateLegacyBag(TrainingBag $bag): array
    {
        $sections = [];

        if (! empty($bag->included_files)) {
            $sections[] = self::listBlock(
                ['ar' => 'الملفات المتضمنة في الحقيبة', 'en' => 'Included files'],
                $bag->included_files,
            );
        }

        $objectiveAr = $bag->getTranslation('general_objective', 'ar', false);
        $objectiveEn = $bag->getTranslation('general_objective', 'en', false);
        if ($objectiveAr || $objectiveEn) {
            $sections[] = self::textBlock(
                ['ar' => 'الهدف العام', 'en' => 'General objective'],
                ['ar' => $objectiveAr, 'en' => $objectiveEn],
            );
        }

        $detailedAr = TextLines::from($bag->getTranslation('detailed_objectives', 'ar', false));
        $detailedEn = TextLines::from($bag->getTranslation('detailed_objectives', 'en', false));
        if ($detailedAr || $detailedEn) {
            $sections[] = self::listBlock(
                ['ar' => 'الأهداف التفصيلية', 'en' => 'Detailed objectives'],
                self::mergeLineItems($detailedAr, $detailedEn),
            );
        }

        $audienceAr = TextLines::from($bag->getTranslation('target_audience', 'ar', false));
        $audienceEn = TextLines::from($bag->getTranslation('target_audience', 'en', false));
        if ($audienceAr || $audienceEn) {
            $sections[] = self::listBlock(
                ['ar' => 'الفئة المستهدفة', 'en' => 'Target audience'],
                self::mergeLineItems($audienceAr, $audienceEn),
            );
        }

        $contentsAr = $bag->getTranslation('contents', 'ar', false);
        $contentsEn = $bag->getTranslation('contents', 'en', false);
        if ($contentsAr || $contentsEn) {
            $sections[] = self::richBlock(
                ['ar' => 'المحاور التدريبية والمحتوى التفصيلي', 'en' => 'Training modules'],
                ['ar' => $contentsAr, 'en' => $contentsEn],
            );
        }

        return $sections;
    }

    /**
     * @param  array<int, string>  $arLines
     * @param  array<int, string>  $enLines
     * @return array<int, array{ar: string, en: string}>
     */
    public static function mergeLineItems(array $arLines, array $enLines): array
    {
        $count = max(count($arLines), count($enLines));
        $items = [];

        for ($i = 0; $i < $count; $i++) {
            $ar = $arLines[$i] ?? '';
            $en = $enLines[$i] ?? '';

            if ($ar === '' && $en === '') {
                continue;
            }

            $items[] = ['ar' => $ar, 'en' => $en];
        }

        return $items;
    }

    public static function listBlock(array $title, array $items): array
    {
        return [
            'type' => 'list',
            'data' => [
                'title' => $title,
                'items' => array_values($items),
            ],
        ];
    }

    public static function textBlock(array $title, array $body): array
    {
        return [
            'type' => 'text',
            'data' => [
                'title' => $title,
                'body' => $body,
            ],
        ];
    }

    public static function richBlock(array $title, array $body): array
    {
        return [
            'type' => 'rich',
            'data' => [
                'title' => $title,
                'body' => $body,
            ],
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $sections
     * @return array<int, array<string, mixed>>
     */
    public static function normalizeRichBlocksForForm(array $sections): array
    {
        return array_map(function (array $section): array {
            if (($section['type'] ?? '') !== 'rich') {
                return $section;
            }

            $blockData = $section['data'] ?? [];

            if (isset($blockData['body']) && is_array($blockData['body'])) {
                $blockData['body_ar'] = $blockData['body']['ar'] ?? '';
                $blockData['body_en'] = $blockData['body']['en'] ?? '';
                unset($blockData['body']);
            }

            $section['data'] = $blockData;

            return $section;
        }, $sections);
    }

    /**
     * @param  array<int, array<string, mixed>>  $sections
     * @return array<int, array<string, mixed>>
     */
    public static function normalizeRichBlocksForStorage(array $sections): array
    {
        return array_map(function (array $section): array {
            if (($section['type'] ?? '') !== 'rich') {
                return $section;
            }

            $blockData = $section['data'] ?? [];

            if (array_key_exists('body_ar', $blockData) || array_key_exists('body_en', $blockData)) {
                $blockData['body'] = [
                    'ar' => $blockData['body_ar'] ?? '',
                    'en' => $blockData['body_en'] ?? '',
                ];

                unset($blockData['body_ar'], $blockData['body_en']);
            }

            $section['data'] = $blockData;

            return $section;
        }, $sections);
    }

    public static function localized(array $field, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $fallback = $locale === 'ar' ? 'en' : 'ar';

        return trim((string) ($field[$locale] ?? $field[$fallback] ?? ''));
    }

    /**
     * @return array<int, array{type: string, title: string, body: string, items: array<int, string>}>
     */
    public static function forDisplay(TrainingBag $bag, ?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();

        return collect($bag->content_sections ?? [])
            ->map(function (array $section) use ($locale): ?array {
                $type = $section['type'] ?? '';
                $data = $section['data'] ?? [];
                $title = self::localized($data['title'] ?? [], $locale);

                if ($type === 'list') {
                    $items = collect($data['items'] ?? [])
                        ->map(fn ($item) => self::localized(is_array($item) ? $item : ['ar' => (string) $item], $locale))
                        ->filter()
                        ->values()
                        ->all();

                    if ($title === '' && $items === []) {
                        return null;
                    }

                    return [
                        'type' => 'list',
                        'title' => $title,
                        'body' => '',
                        'items' => $items,
                    ];
                }

                if ($type === 'text') {
                    $body = self::localized($data['body'] ?? [], $locale);

                    if ($title === '' && $body === '') {
                        return null;
                    }

                    return [
                        'type' => 'text',
                        'title' => $title,
                        'body' => $body,
                        'items' => [],
                    ];
                }

                if ($type === 'rich') {
                    $bodyField = $data['body'] ?? [];

                    if ((! is_array($bodyField) || $bodyField === []) && (isset($data['body_ar']) || isset($data['body_en']))) {
                        $bodyField = [
                            'ar' => $data['body_ar'] ?? '',
                            'en' => $data['body_en'] ?? '',
                        ];
                    }

                    $body = self::localized($bodyField, $locale);

                    if ($title === '' && $body === '') {
                        return null;
                    }

                    return [
                        'type' => 'rich',
                        'title' => $title,
                        'body' => $body,
                        'items' => [],
                    ];
                }

                return null;
            })
            ->filter()
            ->values()
            ->all();
    }
}
