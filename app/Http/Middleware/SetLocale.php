<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next, ?string $locale = null): Response
    {
        $locale = $locale ?? config('app.locale', 'ar');

        if (! in_array($locale, ['ar', 'en'], true)) {
            $locale = 'ar';
        }

        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
