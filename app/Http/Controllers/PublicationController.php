<?php

namespace App\Http\Controllers;

use App\Models\Publication;

class PublicationController extends Controller
{
    public function index()
    {
        $category = request('category');

        $query = Publication::published();

        if ($category) {
            $query->where('category', $category);
        }

        return view('pages.papers.index', [
            'meta' => $this->seoMeta('nav.papers', 'papers.meta_description'),
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.papers'), 'url' => null],
            ]),
            'publications' => $query->get(),
            'categories' => Publication::published()->distinct()->pluck('category')->filter(),
        ]);
    }

    public function show(Publication $paper)
    {
        return view('pages.papers.show', [
            'meta' => [
                'title' => $paper->title . ' | ' . __('site.name'),
                'description' => strip_tags($paper->getTranslation('excerpt', app()->getLocale()) ?? $paper->getTranslation('description', app()->getLocale()) ?? ''),
            ],
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.papers'), 'url' => locale_route('papers.index')],
                ['label' => $paper->title, 'url' => null],
            ]),
            'paper' => $paper,
        ]);
    }
}
