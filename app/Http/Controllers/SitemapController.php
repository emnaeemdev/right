<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;
use App\Models\TrainingBag;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            ['loc' => url('/'), 'priority' => '1.0'],
            ['loc' => url('/en'), 'priority' => '1.0'],
            ['loc' => url('/about'), 'priority' => '0.8'],
            ['loc' => url('/en/about'), 'priority' => '0.8'],
            ['loc' => url('/services'), 'priority' => '0.8'],
            ['loc' => url('/training-bags'), 'priority' => '0.9'],
            ['loc' => url('/consulting'), 'priority' => '0.8'],
            ['loc' => url('/publications'), 'priority' => '0.7'],
            ['loc' => url('/contact'), 'priority' => '0.7'],
        ];

        foreach (TrainingBag::published()->get() as $bag) {
            $urls[] = ['loc' => url('/training-bags/'.$bag->id), 'priority' => '0.8'];
            $urls[] = ['loc' => url('/en/training-bags/'.$bag->id), 'priority' => '0.8'];
        }

        foreach (Project::published()->get() as $project) {
            $urls[] = ['loc' => url('/projects/' . $project->getTranslation('slug', 'ar')), 'priority' => '0.7'];
        }

        return response()->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}
