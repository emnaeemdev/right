<x-layout :meta="$meta">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.publications') }}</h1>
            <p class="section-subtitle reveal">{{ __('publications.intro') }}</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl space-y-4 px-4 lg:px-8">
            @forelse($publications as $pub)
                <div class="reveal flex flex-col gap-4 border-b border-right-teal/10 pb-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <span class="text-xs text-right-teal">{{ $pub->year }} @if($pub->category)<span class="pipe-separator">|</span> {{ $pub->category }}@endif</span>
                        <h2 class="text-lg font-bold text-right-navy">{{ $pub->title }}</h2>
                        <p class="mt-1 text-sm text-right-gray">{{ $pub->description }}</p>
                    </div>
                    @if($pub->pdf_path)
                        <a href="{{ storage_url($pub->pdf_path) }}" target="_blank" class="btn-outline shrink-0">{{ __('publications.download') }}</a>
                    @endif
                </div>
            @empty
                <p class="text-center text-right-gray">—</p>
            @endforelse
        </div>
    </section>
</x-layout>
