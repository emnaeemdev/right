<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TrainingBag;

class HomeController extends Controller
{
    public function index()
    {
        $meta = $this->seoMeta('site.home', 'site.tagline');

        return view('pages.home', [
            'meta' => $meta,
            'services' => Service::published()->take(4)->get(),
            'projects' => Project::published()->where('is_featured', true)->take(4)->get(),
            'experts' => Expert::published()->take(6)->get(),
            'partners' => Partner::published()->get(),
            'stats' => Setting::get('stats', [
                'projects' => 50,
                'experts' => 15,
                'partners' => 30,
                'training_bags' => 25,
            ]),
        ]);
    }
}
