<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <span class="text-sm text-right-teal">{{ $project->year }} <span class="pipe-separator">|</span> {{ $project->field }}</span>
            <h1 class="mt-2 section-title">{{ $project->title }}</h1>
            <p class="section-subtitle">{{ __('projects.client') }}: {{ $project->client }}</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-3xl px-4 lg:px-8">
            <div class="prose max-w-none text-right-gray">
                {!! nl2br(e($project->description)) !!}
            </div>

            @if($project->experts->count())
                <div class="mt-12">
                    <h2 class="text-lg font-bold text-right-navy">{{ __('nav.experts') }}</h2>
                    <div class="mt-4 flex flex-wrap gap-4">
                        @foreach($project->experts as $expert)
                            <span class="rounded-sm bg-right-teal-muted px-4 py-2 text-sm text-right-navy">{{ $expert->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-layout>
