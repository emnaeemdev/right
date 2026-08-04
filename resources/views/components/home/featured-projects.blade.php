<section class="bg-right-offwhite py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <div class="flex items-end justify-between">
            <h2 class="section-title reveal">{{ __('home.featured_projects') }}</h2>
            <a href="{{ locale_route('projects') }}" class="reveal text-sm font-medium text-right-teal hover:text-right-teal-light">
                {{ __('home.view_all') }} →
            </a>
        </div>

        <div class="mt-12 space-y-4">
            @foreach($projects as $i => $project)
                <a href="{{ locale_route('projects.show', $project->getTranslation('slug', app()->getLocale())) }}"
                   @class([
                       'reveal group flex flex-col gap-4 border border-transparent p-6 transition hover:border-right-teal/20 hover:bg-white md:flex-row md:items-center md:justify-between',
                       'md:ms-0' => $i % 2 === 0,
                       'md:ms-12' => $i % 2 === 1,
                   ])>
                    <div>
                        <span class="text-xs font-medium text-right-teal">{{ $project->year }} <span class="pipe-separator">|</span> {{ $project->field }}</span>
                        <h3 class="mt-1 text-xl font-semibold text-right-navy group-hover:text-right-teal">{{ $project->title }}</h3>
                        <p class="mt-1 text-sm text-right-gray">{{ $project->client }}</p>
                    </div>
                    <span class="text-right-teal opacity-0 transition group-hover:opacity-100">→</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
