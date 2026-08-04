<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasTranslatableSlug
{
    public function getRouteSlug(?string $locale = null): string
    {
        return (string) $this->getKey();
    }

    public static function generateSlug(string $title): string
    {
        $slug = Str::slug($title);

        return $slug !== '' ? $slug : Str::random(8);
    }
}
