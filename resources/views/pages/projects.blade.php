<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.projects') }}</h1>
            <p class="section-subtitle reveal">{{ __('projects.intro') }}</p>

            <form method="GET" class="reveal mt-8 flex flex-wrap gap-4">
                <select name="year" onchange="this.form.submit()" class="rounded-sm border border-right-teal/20 px-4 py-2 text-sm">
                    <option value="">{{ __('projects.filter_year') }}</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" @selected(request('year') == $y)>{{ $y }}</option>
                    @endforeach
                </select>
                <select name="field" onchange="this.form.submit()" class="rounded-sm border border-right-teal/20 px-4 py-2 text-sm">
                    <option value="">{{ __('projects.filter_field') }}</option>
                    @foreach($fields as $f)
                        <option value="{{ $f }}" @selected(request('field') == $f)>{{ $f }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl space-y-4 px-4 lg:px-8">
            @forelse($projects as $project)
                <a href="{{ locale_route('projects.show', $project->getTranslation('slug', app()->getLocale())) }}"
                   class="reveal group block border border-transparent p-6 transition hover:border-right-teal/20 hover:bg-right-offwhite">
                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                        <div>
                            <span class="text-xs text-right-teal">{{ $project->year }} <span class="pipe-separator">|</span> {{ $project->field }}</span>
                            <h2 class="text-xl font-bold text-right-navy group-hover:text-right-teal">{{ $project->title }}</h2>
                            <p class="text-sm text-right-gray">{{ __('projects.client') }}: {{ $project->client }}</p>
                        </div>
                        <span class="text-right-teal opacity-0 transition group-hover:opacity-100">→</span>
                    </div>
                </a>
            @empty
                <p class="text-center text-right-gray">{{ __('projects.all') }}</p>
            @endforelse
        </div>
    </section>
</x-layout>
