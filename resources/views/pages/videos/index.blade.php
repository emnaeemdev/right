<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.videos') }}</h1>
            <p class="section-subtitle reveal">{{ __('videos.intro') }}</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:grid-cols-2 lg:grid-cols-3 lg:px-8">
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
    </section>
</x-layout>
