<?php

use App\Helpers\LocaleHelper;

if (! function_exists('locale_route')) {
    function locale_route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        return LocaleHelper::route($name, $parameters, $absolute);
    }
}

if (! function_exists('alternate_locale_url')) {
    function alternate_locale_url(): string
    {
        return LocaleHelper::localizedUrl();
    }
}

if (! function_exists('storage_url')) {
    function storage_url(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
    }
}

if (! function_exists('nav_is_active')) {
    function nav_is_active(string $route): bool
    {
        $patterns = match ($route) {
            'home' => ['home', 'en.home'],
            'training-bags.index' => ['training-bags.*', 'en.training-bags.*'],
            'papers.index' => ['papers.*', 'en.papers.*'],
            'activities.index' => ['activities.*', 'videos.*', 'en.activities.*', 'en.videos.*'],
            'quote-request' => ['quote-request', 'en.quote-request'],
            'consulting' => ['consulting', 'en.consulting'],
            'services' => ['services', 'en.services'],
            'about' => ['about', 'en.about'],
            'contact' => ['contact', 'en.contact'],
            default => [$route, 'en.'.$route],
        };

        return request()->routeIs($patterns);
    }
}
