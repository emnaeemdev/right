<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;

abstract class Controller
{
    protected function seoMeta(string $titleKey, ?string $descriptionKey = null): array
    {
        $siteName = Setting::get('site_name', [
            'ar' => 'مركز رايت للبحوث والاستشارات والتدريب',
            'en' => 'RIGHT Center for Research, Consultancy & Training',
        ]);

        return [
            'title' => __($titleKey) . ' | ' . ($siteName[app()->getLocale()] ?? $siteName['ar']),
            'description' => $descriptionKey ? __($descriptionKey) : null,
        ];
    }

    protected function breadcrumbs(array $items): array
    {
        return array_merge(
            [['label' => __('nav.home'), 'url' => locale_route('home')]],
            $items
        );
    }

    protected function validateSimpleCaptcha(\Illuminate\Http\Request $request, string $key): ?\Illuminate\Http\RedirectResponse
    {
        $submittedKey = (string) $request->input('captcha_key', '');

        if ($submittedKey !== $key || ! \App\Support\SimpleCaptcha::verify($key, $request->input('captcha_answer'))) {
            return back()
                ->withErrors(['captcha' => __('forms.captcha_invalid')])
                ->withInput($request->except('captcha_answer'));
        }

        return null;
    }
}
