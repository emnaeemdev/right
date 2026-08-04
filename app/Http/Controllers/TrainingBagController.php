<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use App\Models\TrainingBag;
use App\Support\TrainingFieldOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class TrainingBagController extends Controller
{
    public function index()
    {
        $query = TrainingBag::published()->withCount('samples');

        if ($field = request('field')) {
            $query->where('field', $field);
        }
        if ($type = request('type')) {
            $query->where('type', $type);
        }
        if ($duration = request('duration')) {
            if ($duration === 'short') {
                $query->where('duration_days', '<=', 3);
            } elseif ($duration === 'medium') {
                $query->whereBetween('duration_days', [4, 10]);
            } elseif ($duration === 'long') {
                $query->where('duration_days', '>', 10);
            }
        }

        return view('pages.training-bags.index', [
            'meta' => $this->seoMeta('nav.training_bags', 'training_bags.meta_description'),
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.training_bags'), 'url' => null],
            ]),
            'bags' => $query->get(),
            'fields' => TrainingBag::published()->distinct()->pluck('field')->filter(),
            'fieldOptions' => TrainingFieldOptions::all(),
        ]);
    }

    public function show(TrainingBag $trainingBag)
    {
        $trainingBag->load(['cycleSteps', 'samples' => fn ($q) => $q->where('is_public', true)]);

        return view('pages.training-bags.show', [
            'meta' => [
                'title' => $trainingBag->title . ' | ' . __('site.name'),
                'description' => strip_tags($trainingBag->getTranslation('description', app()->getLocale())),
            ],
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.training_bags'), 'url' => locale_route('training-bags.index')],
                ['label' => $trainingBag->title, 'url' => null],
            ]),
            'bag' => $trainingBag,
        ]);
    }

    public function quote(Request $request)
    {
        $key = 'quote:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['rate_limit' => __('forms.rate_limit')])->withInput();
        }

        RateLimiter::hit($key, 60);

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
