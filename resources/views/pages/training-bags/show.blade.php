<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-5xl px-4 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-5 lg:items-start">
                @if($bag->image)
                    <div class="lg:col-span-2">
                        <div class="overflow-hidden rounded-sm border border-right-teal/10 bg-white p-2">
                            <img src="{{ storage_url($bag->image) }}" alt="{{ $bag->title }}" class="mx-auto max-h-[420px] w-full object-contain">
                        </div>
                    </div>
                @endif
                <div class="{{ $bag->image ? 'lg:col-span-3' : 'lg:col-span-5' }}">
                    @php($headerMeta = $bag->metaHighlightLabels())
                    <div class="flex flex-wrap gap-2 text-sm text-right-teal">
                        @if($bag->field)
                            <span>{{ \App\Support\TrainingFieldOptions::label($bag->field) }}</span>
                        @endif
                        @foreach($headerMeta as $highlight)
                            <span class="pipe-separator">|</span>
                            <span>{{ $highlight }}</span>
                        @endforeach
                    </div>
                    <h1 class="mt-4 section-title">{{ $bag->title }}</h1>
                    @if($bag->description)
                        <p class="section-subtitle">{{ $bag->description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @php($sections = $bag->displaySections())

    @if(count($sections))
        @include('pages.training-bags._content-sections', ['sections' => $sections])
    @endif

    @if($bag->samples->count())
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-5xl px-4 lg:px-8">
            <h2 class="section-title reveal">{{ __('training_bags.samples') }}</h2>
            <div class="mt-12 grid gap-8 md:grid-cols-2">
                @foreach($bag->samples as $sample)
                    <div class="reveal rounded-sm bg-white p-6">
                        @if($sample->type === 'video' && $sample->video_url)
                            <div class="aspect-video overflow-hidden rounded-sm bg-right-navy">
                                <iframe src="{{ $sample->video_url }}" class="h-full w-full" allowfullscreen loading="lazy"></iframe>
                            </div>
                            <p class="mt-4 text-sm font-medium text-right-navy">{{ $sample->displayTitle() }}</p>
                        @elseif($sample->type === 'activity' && $sample->activity_html)
                            <div class="rounded-sm border border-right-teal/10 p-4 text-sm">{!! $sample->activity_html !!}</div>
                            <p class="mt-4 text-sm font-medium text-right-navy">{{ $sample->displayTitle() }}</p>
                        @elseif($sample->type === 'pdf' && $sample->pdf_path)
                            <a href="{{ storage_url($sample->pdf_path) }}" target="_blank" class="btn-outline w-full">{{ $sample->displayTitle() }}</a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section class="bg-right-teal-muted py-20">
        <div class="mx-auto max-w-2xl px-4 lg:px-8">
            <h2 class="section-title text-center reveal">{{ __('training_bags.request_quote') }}</h2>
            <form action="{{ locale_route('quote.store') }}" method="POST" class="reveal mt-8 space-y-4">
                @csrf
                <input type="hidden" name="training_bag_id" value="{{ $bag->id }}">
                <input type="text" name="name" required placeholder="{{ __('forms.name') }}"
                       class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                <input type="text" name="organization" placeholder="{{ __('forms.organization') }}"
                       class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                <input type="email" name="email" required placeholder="{{ __('forms.email') }}"
                       class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                <input type="text" name="phone" placeholder="{{ __('forms.phone') }}"
                       class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                <textarea name="notes" rows="3" placeholder="{{ __('forms.notes') }}"
                          class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal"></textarea>
                @if(session('success'))
                    <p class="text-sm text-right-teal">{{ session('success') }}</p>
                @endif
                @error('rate_limit')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                <x-simple-captcha form="quote" />
                <button type="submit" class="btn-primary w-full">{{ __('training_bags.request_quote') }}</button>
            </form>
        </div>
    </section>

    @push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endpush
</x-layout>
