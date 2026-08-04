<?php

namespace App\Http\Controllers;

use App\Models\TrainingActivity;
use App\Models\VideoItem;

class ActivityController extends Controller
{
    public function index()
    {
        return view('pages.activities.index', [
            'meta' => $this->seoMeta('nav.activities', 'activities.meta_description'),
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.activities'), 'url' => null],
            ]),
            'activities' => TrainingActivity::published()->get(),
            'videos' => VideoItem::published()->get(),
        ]);
    }

    public function show(TrainingActivity $activity)
    {
        return view('pages.activities.show', [
            'meta' => [
                'title' => $activity->title . ' | ' . __('site.name'),
                'description' => strip_tags($activity->getTranslation('excerpt', app()->getLocale()) ?? ''),
            ],
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.activities'), 'url' => locale_route('activities.index')],
                ['label' => $activity->title, 'url' => null],
            ]),
            'activity' => $activity,
        ]);
    }
}
