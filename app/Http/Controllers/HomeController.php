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

        $storedStats = Setting::get('stats', []);

        $stats = [
            'years' => (int) ($storedStats['years'] ?? 15),
            'organizations' => (int) ($storedStats['organizations'] ?? $storedStats['projects'] ?? 50),
            'partners' => (int) ($storedStats['partners'] ?? 10),
            'experts' => (int) ($storedStats['experts'] ?? 30),
        ];

        return view('pages.home', [
            'meta' => $meta,
            'services' => Service::published()->take(4)->get(),
            'projects' => Project::published()->where('is_featured', true)->take(3)->get(),
            'experts' => Expert::published()->take(4)->get(),
            'partners' => Partner::published()->get(),
            'stats' => $stats,
        ]);
    }
}
