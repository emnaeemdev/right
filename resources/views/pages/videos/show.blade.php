<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-4xl px-4 lg:px-8">
            <h1 class="section-title">{{ $video->title }}</h1>
            @if($video->description)
                <p class="section-subtitle">{{ $video->description }}</p>
            @endif
        </div>
    </section>

    <section class="py-12">
        <div class="mx-auto max-w-4xl px-4 lg:px-8">
            <div class="aspect-video overflow-hidden rounded-sm bg-right-navy">
                <iframe src="{{ $video->video_url }}" class="h-full w-full" allowfullscreen loading="lazy"></iframe>
            </div>
        </div>
    </section>
</x-layout>
