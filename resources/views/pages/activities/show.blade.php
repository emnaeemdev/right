<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-4xl px-4 lg:px-8">
            <h1 class="section-title">{{ $activity->title }}</h1>
            @if($activity->excerpt)
                <p class="section-subtitle">{{ $activity->excerpt }}</p>
            @endif
        </div>
    </section>

    <section class="py-12">
        <div class="mx-auto max-w-4xl px-4 lg:px-8">
            @if($activity->content)
                <div class="rich-content activity-content-no-images">
                    {!! $activity->content !!}
                </div>
            @endif

            @if($activity->pdf_path || $activity->word_path)
                <div class="mt-10 flex flex-wrap gap-4">
                    @if($activity->pdf_path)
                        <a href="{{ storage_url($activity->pdf_path) }}" target="_blank" class="btn-primary">
                            {{ __('activities.download_pdf') }}
                        </a>
                    @endif
                    @if($activity->word_path)
                        <a href="{{ storage_url($activity->word_path) }}" target="_blank" class="btn-outline">
                            {{ __('activities.download_word') }}
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>
</x-layout>
