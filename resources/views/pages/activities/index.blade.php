<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.activities') }}</h1>
            <p class="section-subtitle reveal">{{ __('activities.intro') }}</p>
        </div>
    </section>

    <section class="sticky top-[72px] z-40 border-b border-right-teal/10 bg-white/95 backdrop-blur-sm">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="content-tabs flex gap-2 py-3" role="tablist" aria-label="{{ __('nav.activities') }}">
                <button type="button"
                        class="content-tab is-active"
                        role="tab"
                        aria-selected="true"
                        aria-controls="activities-panel-activities"
                        data-content-tab="activities">
                    {{ __('activities.section_title') }}
                    <span class="ms-1 text-xs opacity-70">({{ $activities->count() }})</span>
                </button>
                <button type="button"
                        class="content-tab"
                        role="tab"
                        aria-selected="false"
                        aria-controls="activities-panel-videos"
                        data-content-tab="videos">
                    {{ __('activities.videos_title') }}
                    <span class="ms-1 text-xs opacity-70">({{ $videos->count() }})</span>
                </button>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div id="activities-panel-activities"
                 class="content-panel is-active"
                 role="tabpanel"
                 data-content-panel="activities">
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($activities as $activity)
                        <a href="{{ locale_route('activities.show', ['activity' => $activity->id]) }}"
                           class="reveal group overflow-hidden rounded-sm border border-right-teal/10 bg-white transition hover:border-right-teal/30 hover:shadow-sm">
                            <div class="aspect-video overflow-hidden bg-right-teal-muted">
                                @if($activity->image)
                                    <img src="{{ storage_url($activity->image) }}" alt="{{ $activity->title }}" class="h-full w-full object-cover transition group-hover:scale-105" loading="lazy">
                                @else
                                    <div class="flex h-full items-center justify-center text-4xl text-right-teal/30">✓</div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h2 class="text-lg font-bold text-right-navy group-hover:text-right-teal">{{ $activity->title }}</h2>
                                <p class="mt-2 text-sm text-right-gray line-clamp-3">{{ $activity->excerpt }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="col-span-full py-12 text-center text-right-gray">—</p>
                    @endforelse
                </div>
            </div>

            <div id="activities-panel-videos"
                 class="content-panel hidden"
                 role="tabpanel"
                 data-content-panel="videos"
                 hidden>
                <p class="reveal mb-8 max-w-3xl text-right-gray">{{ __('activities.videos_intro') }}</p>
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($videos as $video)
                        <a href="{{ locale_route('videos.show', ['video' => $video->id]) }}"
                           class="reveal group overflow-hidden rounded-sm border border-right-teal/10 bg-white transition hover:border-right-teal/30">
                            <div class="relative aspect-video overflow-hidden bg-right-navy">
                                @if($video->thumbnail)
                                    <img src="{{ storage_url($video->thumbnail) }}" alt="{{ $video->title }}" class="h-full w-full object-cover opacity-80 transition group-hover:opacity-100" loading="lazy">
                                @endif
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-right-teal/90 text-white transition group-hover:scale-110">
                                        <svg class="h-6 w-6 ms-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5">
                                <h2 class="font-bold text-right-navy group-hover:text-right-teal">{{ $video->title }}</h2>
                                @if($video->description)
                                    <p class="mt-2 text-sm text-right-gray line-clamp-2">{{ $video->description }}</p>
                                @endif
                            </div>
                        </a>
                    @empty
                        <p class="col-span-full py-12 text-center text-right-gray">—</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-layout>
