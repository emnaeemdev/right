<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.papers') }}</h1>
            <p class="section-subtitle reveal">{{ __('papers.intro') }}</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:grid-cols-2 lg:grid-cols-3 lg:px-8">
            @forelse($publications as $paper)
                <a href="{{ locale_route('papers.show', ['paper' => $paper->id]) }}"
                   class="reveal group flex flex-col overflow-hidden rounded-sm border border-right-teal/10 bg-white transition hover:border-right-teal/30 hover:shadow-sm">
                    <div class="aspect-[4/3] overflow-hidden bg-right-teal-muted">
                        @if($paper->image)
                            <img src="{{ storage_url($paper->image) }}" alt="{{ $paper->title }}" class="h-full w-full object-cover transition group-hover:scale-105" loading="lazy">
                        @else
                            <div class="flex h-full items-center justify-center text-4xl text-right-teal/30">📄</div>
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <span class="text-xs text-right-teal">{{ $paper->year }} @if($paper->category)<span class="pipe-separator">|</span> {{ __('fields.' . $paper->category) }}@endif</span>
                        <h2 class="mt-2 text-lg font-bold text-right-navy group-hover:text-right-teal">{{ $paper->title }}</h2>
                        <p class="mt-2 flex-1 text-sm text-right-gray line-clamp-3">{{ $paper->excerpt ?? $paper->description }}</p>
                        <span class="mt-4 text-sm font-medium text-right-teal group-hover:text-right-teal-light">
                            {{ __('papers.read_more') }} →
                        </span>
                    </div>
                </a>
            @empty
                <p class="col-span-full py-12 text-center text-right-gray">—</p>
            @endforelse
        </div>
    </section>
</x-layout>
