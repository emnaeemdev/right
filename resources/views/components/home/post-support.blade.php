<section class="bg-right-white py-20">
    <div class="mx-auto grid max-w-7xl gap-12 px-4 lg:grid-cols-2 lg:px-8">
        <div class="reveal">
            <h2 class="section-title">{{ __('home.support_title') }}</h2>
            <p class="section-subtitle">{{ __('home.support_desc') }}</p>
        </div>
        <div class="reveal space-y-6 border-s-2 border-right-teal/30 ps-8">
            @foreach(['support_1', 'support_2', 'support_3'] as $i => $key)
                <div class="relative">
                    <div class="absolute -start-[calc(2rem+5px)] top-1 h-3 w-3 rounded-full bg-right-teal"></div>
                    <p class="text-sm font-medium text-right-navy">{{ __('home.' . $key) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
