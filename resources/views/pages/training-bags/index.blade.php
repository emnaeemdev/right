<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.training_bags') }}</h1>
            <p class="section-subtitle reveal">{{ __('training_bags.intro') }}</p>

            <form method="GET" class="reveal mt-8">
                <div class="filter-bar">
                    <div class="filter-item">
                        <label for="filter-field" class="filter-label">{{ __('training_bags.filter_field') }}</label>
                        <select id="filter-field" name="field" onchange="this.form.submit()" class="filter-select">
                            <option value="">{{ __('training_bags.all_fields') }}</option>
                            @foreach($fieldOptions as $key => $label)
                                <option value="{{ $key }}" @selected(request('field') == $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="filter-type" class="filter-label">{{ __('training_bags.filter_type') }}</label>
                        <select id="filter-type" name="type" onchange="this.form.submit()" class="filter-select">
                            <option value="">{{ __('training_bags.all_types') }}</option>
                            <option value="ready" @selected(request('type') == 'ready')>{{ __('training_bags.ready') }}</option>
                            <option value="custom" @selected(request('type') == 'custom')>{{ __('training_bags.custom') }}</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="filter-duration" class="filter-label">{{ __('training_bags.filter_duration') }}</label>
                        <select id="filter-duration" name="duration" onchange="this.form.submit()" class="filter-select">
                            <option value="">{{ __('training_bags.all_durations') }}</option>
                            <option value="short" @selected(request('duration') == 'short')>{{ __('training_bags.short') }}</option>
                            <option value="medium" @selected(request('duration') == 'medium')>{{ __('training_bags.medium') }}</option>
                            <option value="long" @selected(request('duration') == 'long')>{{ __('training_bags.long') }}</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl divide-y divide-right-teal/10 px-4 lg:px-8">
            @forelse($bags as $bag)
                <a href="{{ locale_route('training-bags.show', $bag->id) }}"
                   class="reveal group flex flex-col gap-2 py-8 transition hover:bg-right-offwhite md:flex-row md:items-center md:justify-between md:px-6">
                    <div>
                        <div class="flex flex-wrap gap-2 text-xs text-right-teal">
                            @if($bag->field)<span>{{ \App\Support\TrainingFieldOptions::label($bag->field) }}</span>@endif
                            @foreach($bag->metaHighlightLabels() as $highlight)
                                @if($loop->first && $bag->field)<span class="pipe-separator">|</span>@elseif(!$loop->first)<span class="pipe-separator">|</span>@endif
                                <span>{{ $highlight }}</span>
                            @endforeach
                        </div>
                        <h2 class="mt-2 text-xl font-bold text-right-navy group-hover:text-right-teal">{{ $bag->title }}</h2>
                        <p class="mt-1 text-sm text-right-gray line-clamp-2">{{ $bag->description }}</p>
                    </div>
                    <span class="mt-4 text-sm font-medium text-right-teal md:mt-0">{{ __('training_bags.explore') }} →</span>
                </a>
            @empty
                <p class="py-12 text-center text-right-gray">—</p>
            @endforelse
        </div>
    </section>
</x-layout>
