<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use App\Models\TrainingBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class QuoteRequestController extends Controller
{
    public function index()
    {
        return view('pages.quote-request', [
            'meta' => $this->seoMeta('nav.quote_request', 'quote_request.meta_description'),
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.quote_request'), 'url' => null],
            ]),
            'bags' => TrainingBag::published()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $key = 'quote:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['rate_limit' => __('forms.rate_limit')])->withInput();
        }

        RateLimiter::hit($key, 60);

        if ($response = $this->validateSimpleCaptcha($request, 'quote')) {
            return $response;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'organization' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'training_bag_id' => 'nullable|exists:training_bags,id',
            'notes' => 'nullable|string|max:5000',
        ]);

        QuoteRequest::create($validated);

        return back()->with('success', __('forms.quote_success'));
    }
}
