<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait InteractsWithTranslatableFields
{
    public static function getTranslatableFields(): array
    {
        return [];
    }

    /**
     * Rich text fields stored as flat form keys (e.g. content_ar) because
     * Filament's Trix editor does not hydrate reliably with dot notation.
     *
     * @return array<int, string>
     */
    public static function getRichEditorFields(): array
    {
        return [];
    }

    protected static function translatableLocaleValue(array $data, string $field, string $locale): ?string
    {
        $dotKey = "{$field}.{$locale}";

        if (array_key_exists($dotKey, $data)) {
            return static::normalizeTranslatableValue($data[$dotKey]);
        }

        $nested = Arr::get($data, $dotKey);

        if ($nested !== null) {
            return static::normalizeTranslatableValue($nested);
        }

        if (is_array($data[$field] ?? null) && array_key_exists($locale, $data[$field])) {
            return static::normalizeTranslatableValue($data[$field][$locale]);
        }

        return null;
    }

    protected static function normalizeTranslatableValue(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            return $value;
        }

        if (is_scalar($value)) {
            return (string) $value;
        }

        return null;
    }

    public static function processTranslatableData(array $data, ?array $fields = null): array
    {
        foreach ($fields ?? static::getTranslatableFields() as $field) {
            $translations = [];

            foreach (['ar', 'en'] as $locale) {
                $value = static::translatableLocaleValue($data, $field, $locale);

                if ($value !== null && trim($value) !== '') {
                    $translations[$locale] = $value;
                }
            }

            $data[$field] = $translations;

            unset($data["{$field}.ar"], $data["{$field}.en"]);
        }

        foreach (static::getRichEditorFields() as $field) {
            $translations = is_array($data[$field] ?? null) ? $data[$field] : [];

            foreach (['ar', 'en'] as $locale) {
                $flatKey = "{$field}_{$locale}";

                if (! array_key_exists($flatKey, $data)) {
                    continue;
                }

                $value = static::normalizeTranslatableValue($data[$flatKey]);

                if ($value !== null && trim($value) !== '') {
                    $translations[$locale] = $value;
                } else {
                    unset($translations[$locale]);
                }

                unset($data[$flatKey]);
            }

            $data[$field] = $translations;
        }

        return static::ensureTranslatableSlugs($data);
    }

    public static function expandTranslatableData(array $data, object $record, ?array $fields = null): array
    {
        foreach ($fields ?? static::getTranslatableFields() as $field) {
            $data[$field] = [
                'ar' => $record->getTranslation($field, 'ar', false) ?? '',
                'en' => $record->getTranslation($field, 'en', false) ?? '',
            ];
        }

        foreach (static::getRichEditorFields() as $field) {
            foreach (['ar', 'en'] as $locale) {
                $data["{$field}_{$locale}"] = $record->getTranslation($field, $locale, false) ?? '';
            }

            unset($data[$field]);
        }

        return $data;
    }

    public static function ensureTranslatableSlugs(array $data): array
    {
        /** @var Model $model */
        $model = static::getModel()::make();

        if (! in_array('slug', $model->translatable ?? [], true)) {
            return $data;
        }

        $slugs = is_array($data['slug'] ?? null) ? $data['slug'] : [];

        foreach (['ar', 'en'] as $locale) {
            if (! empty($slugs[$locale])) {
                continue;
            }

            $source = static::translatableLocaleValue($data, 'title', $locale)
                ?? static::translatableLocaleValue($data, 'name', $locale);

            if ($source === null || trim($source) === '') {
                continue;
            }

            $slugs[$locale] = static::getModel()::generateSlug($source);
        }

        if (empty($slugs['ar'])) {
            $slugs['ar'] = Str::random(10);
        }

        $data['slug'] = $slugs;

        return $data;
    }
}
