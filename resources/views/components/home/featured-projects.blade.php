<section class="bg-right-offwhite py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <div class="flex items-end justify-between gap-4">
            <div class="reveal">
                <p class="section-kicker">{{ __('home.projects_kicker') }}</p>
                <h2 class="section-title mt-2">{{ __('home.featured_projects') }}</h2>
            </div>
            <a href="{{ locale_route('projects') }}" class="btn-primary-sm reveal shrink-0">
                {{ __('home.all_projects') }}
            </a>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($projects as $i => $project)
                <a href="{{ locale_route('projects.show', $project->getTranslation('slug', app()->getLocale())) }}"
                   class="project-card reveal group"
                   style="transition-delay: {{ $i * 80 }}ms">
                    <div class="aspect-[16/10] overflow-hidden bg-right-teal-muted">
                        @if($project->image)
                            <img src="{{ storage_url($project->image) }}"
                                 alt="{{ $project->title }}"
                                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                 loading="lazy">
                        @else
                            <div class="flex h-full items-center justify-center text-right-teal/30">
                                <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-right-navy group-hover:text-right-teal">{{ $project->title }}</h3>
                        <p class="mt-2 text-sm text-right-gray line-clamp-2">{{ $project->description }}</p>
                        @if($project->field || $project->year)
                            <span class="mt-4 inline-block rounded-full bg-right-green/15 px-3 py-1 text-xs font-semibold text-green-700">
                                {{ trim(($project->field ? $project->field . ' ' : '') . ($project->year ?? '')) }}
                            </span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
