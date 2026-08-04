<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.about') }}</h1>
            <p class="section-subtitle reveal">{{ __('about.meta_description') }}</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto grid max-w-7xl gap-16 px-4 lg:grid-cols-2 lg:px-8">
            <div class="reveal">
                <h2 class="text-2xl font-bold text-right-teal">{{ __('about.vision_title') }}</h2>
                <p class="mt-4 text-lg text-right-navy">{{ __('about.vision') }}</p>
            </div>
            <div class="reveal">
                <h2 class="text-2xl font-bold text-right-teal">{{ __('about.mission_title') }}</h2>
                <p class="mt-4 text-lg text-right-navy">{{ __('about.mission') }}</p>
            </div>
        </div>
    </section>

    <section class="bg-right-offwhite py-20">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h2 class="section-title reveal text-center">{{ __('about.values_title') }}</h2>
            <div class="mt-12 grid gap-8 md:grid-cols-3">
                @foreach([['value_1', 'value_1_desc'], ['value_2', 'value_2_desc'], ['value_3', 'value_3_desc']] as $pair)
                    <div class="reveal rounded-sm bg-white p-8">
                        <div class="text-2xl font-bold text-right-teal">✓</div>
                        <h3 class="mt-4 font-semibold text-right-navy">{{ __('about.' . $pair[0]) }}</h3>
                        <p class="mt-2 text-sm text-right-gray">{{ __('about.' . $pair[1]) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-3xl px-4 text-center lg:px-8">
            <h2 class="section-title reveal">{{ __('about.advantage_title') }}</h2>
            <p class="reveal mt-6 text-lg leading-relaxed text-right-gray">{{ __('about.advantage') }}</p>
            <a href="{{ locale_route('contact') }}" class="btn-primary reveal mt-8">{{ __('nav.contact') }}</a>
        </div>
    </section>
</x-layout>
