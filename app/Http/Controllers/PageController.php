<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about', [
            'meta' => $this->seoMeta('nav.about', 'about.meta_description'),
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.about'), 'url' => null],
            ]),
        ]);
    }

    public function services()
    {
        return view('pages.services', [
            'meta' => $this->seoMeta('nav.services', 'services.meta_description'),
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.services'), 'url' => null],
            ]),
            'services' => Service::published()->get(),
        ]);
    }

    public function experts()
    {
        return view('pages.experts', [
            'meta' => $this->seoMeta('nav.experts', 'experts.meta_description'),
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.experts'), 'url' => null],
            ]),
            'experts' => Expert::published()->get(),
        ]);
    }

    public function partners()
    {
        return view('pages.partners', [
            'meta' => $this->seoMeta('nav.partners', 'partners.meta_description'),
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.partners'), 'url' => null],
            ]),
            'partners' => Partner::published()->get()->groupBy('category'),
        ]);
    }

    public function projects()
    {
        $year = request('year');
        $field = request('field');

        $query = Project::published()->with('experts');

        if ($year) {
            $query->where('year', $year);
        }
        if ($field) {
            $query->where('field', $field);
        }

        return view('pages.projects', [
            'meta' => $this->seoMeta('nav.projects', 'projects.meta_description'),
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.projects'), 'url' => null],
            ]),
            'projects' => $query->orderByDesc('year')->get(),
            'years' => Project::published()->distinct()->orderByDesc('year')->pluck('year'),
            'fields' => Project::published()->distinct()->pluck('field')->filter(),
        ]);
    }

    public function projectShow(Project $project)
    {
        return view('pages.project-show', [
            'meta' => [
                'title' => $project->title . ' | ' . __('site.name'),
                'description' => strip_tags($project->getTranslation('description', app()->getLocale())),
            ],
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.projects'), 'url' => locale_route('projects')],
                ['label' => $project->title, 'url' => null],
            ]),
            'project' => $project->load('experts'),
        ]);
    }
}
