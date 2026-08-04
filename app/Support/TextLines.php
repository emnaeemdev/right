<?php

namespace App\Support;

class TextLines
{
    public static function from(?string $text): array
    {
        if ($text === null) {
            return [];
        }

        $text = trim($text);

        if ($text === '') {
            return [];
        }

        $normalized = str_replace(["\r\n", "\r"], "\n", $text);

        return array_values(array_filter(
            array_map('trim', explode("\n", $normalized)),
            fn (string $line): bool => $line !== '',
        ));
    }
}
