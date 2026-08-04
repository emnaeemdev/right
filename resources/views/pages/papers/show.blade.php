<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-4xl px-4 lg:px-8">
            <span class="text-sm text-right-teal">{{ $paper->year }} @if($paper->category)<span class="pipe-separator">|</span> {{ __('fields.' . $paper->category) }}@endif</span>
            <h1 class="mt-2 section-title">{{ $paper->title }}</h1>
            @if($paper->excerpt ?? $paper->description)
                <p class="section-subtitle">{{ $paper->excerpt ?? $paper->description }}</p>
            @endif
        </div>
    </section>

    <section class="py-12">
        <div class="mx-auto max-w-4xl px-4 lg:px-8">
            @if($paper->content)
                <div class="rich-content">
                    {!! $paper->content !!}
                </div>
            @elseif($paper->description)
                <div class="rich-content">
                    {!! nl2br(e($paper->description)) !!}
                </div>
            @endif

            @if($paper->pdf_path || $paper->word_path)
                <div class="mt-10 flex flex-wrap gap-4">
                    @if($paper->pdf_path)
                        <a href="{{ storage_url($paper->pdf_path) }}" target="_blank" class="btn-primary">{{ __('papers.download_pdf') }}</a>
                    @endif
                    @if($paper->word_path)
                        <a href="{{ storage_url($paper->word_path) }}" target="_blank" class="btn-outline">{{ __('papers.download_word') }}</a>
                    @endif
                </div>
            @endif
        </div>
    </section>
</x-layout>
