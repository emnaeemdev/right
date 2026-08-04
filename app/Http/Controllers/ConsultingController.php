<?php

namespace App\Http\Controllers;

use App\Models\ConsultationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ConsultingController extends Controller
{
    public function index()
    {
        return view('pages.consulting', [
            'meta' => $this->seoMeta('nav.consulting', 'consulting.meta_description'),
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.consulting'), 'url' => null],
            ]),
            'types' => [
                'oca' => __('consulting.types.oca'),
                'toc' => __('consulting.types.toc'),
                'governance' => __('consulting.types.governance'),
                'm_e' => __('consulting.types.m_e'),
                'capacity' => __('consulting.types.capacity'),
                'other' => __('consulting.types.other'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $key = 'consulting:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['rate_limit' => __('forms.rate_limit')])->withInput();
        }

        RateLimiter::hit($key, 60);

        if ($response = $this->validateSimpleCaptcha($request, 'consulting')) {
            return $response;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organization' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'consultation_type' => 'required|string|max:100',
            'description' => 'required|string|max:5000',
            'budget_range' => 'nullable|string|max:100',
        ]);

        ConsultationRequest::create($validated);

        return back()->with('success', __('forms.consulting_success'));
    }
}
