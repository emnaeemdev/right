<?php

namespace App\Support;

use App\Models\Setting;

class TrainingFieldOptions
{
    public static function all(): array
    {
        $stored = Setting::get('training_fields');

        if (is_array($stored) && $stored !== []) {
            return $stored;
        }

        return __('fields');
    }

    public static function label(?string $key): ?string
    {
        if ($key === null || $key === '') {
            return null;
        }

        return self::all()[$key] ?? $key;
    }
}
