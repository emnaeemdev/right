<?php

namespace App\Http\Controllers;

use App\Models\VideoItem;

class VideoController extends Controller
{
    public function index()
    {
        return view('pages.videos.index', [
            'meta' => $this->seoMeta('nav.videos', 'videos.meta_description'),
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.videos'), 'url' => null],
            ]),
            'videos' => VideoItem::published()->get(),
        ]);
    }

    public function show(VideoItem $video)
    {
        return view('pages.videos.show', [
            'meta' => [
                'title' => $video->title . ' | ' . __('site.name'),
                'description' => strip_tags($video->getTranslation('description', app()->getLocale()) ?? ''),
            ],
            'breadcrumbs' => $this->breadcrumbs([
                ['label' => __('nav.activities'), 'url' => locale_route('activities.index').'#videos'],
                ['label' => $video->title, 'url' => null],
            ]),
            'video' => $video,
        ]);
    }
}
