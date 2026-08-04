<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;

class LocaleHelper
{
    public static function isRtl(): bool
    {
        return App::getLocale() === 'ar';
    }

    public static function direction(): string
    {
        return self::isRtl() ? 'rtl' : 'ltr';
    }

    public static function alternateLocale(): string
    {
        return App::getLocale() === 'ar' ? 'en' : 'ar';
    }

    public static function localizedUrl(?string $locale = null): string
    {
        $locale = $locale ?? self::alternateLocale();
        $path = request()->path();

        if (str_starts_with($path, 'en/')) {
            $path = substr($path, 3);
        } elseif ($path === 'en') {
            $path = '';
        }

        if ($locale === 'en') {
            return url('en/' . ltrim($path, '/'));
        }

        return url($path === 'en' ? '' : $path);
    }

    public static function route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        $locale = App::getLocale();

        if ($locale === 'en') {
            return route('en.' . $name, $parameters, $absolute);
        }

        return route($name, $parameters, $absolute);
    }
}
