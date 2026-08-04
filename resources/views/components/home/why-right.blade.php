<section class="bg-right-white py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <div class="reveal mx-auto max-w-3xl text-center">
            <h2 class="section-title">{{ __('home.why_right') }}</h2>
            <blockquote class="mt-8 text-2xl font-light leading-relaxed text-right-navy md:text-3xl">
                "{{ __('home.why_quote') }}"
            </blockquote>
        </div>

        <div class="mt-16 grid gap-0 md:grid-cols-3">
            @foreach([
                ['about.value_1', 'about.value_1_desc'],
                ['about.value_2', 'about.value_2_desc'],
                ['about.value_3', 'about.value_3_desc'],
            ] as $i => [$title, $desc])
                <div @class(['reveal p-8 text-center', 'md:border-s md:border-right-teal/20' => $i > 0])>
                    <div class="text-3xl font-bold text-right-teal">✓</div>
                    <h3 class="mt-4 font-semibold text-right-navy">{{ __($title) }}</h3>
                    <p class="mt-2 text-sm text-right-gray">{{ __($desc) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
