<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <div class="reveal text-center">
            <p class="section-kicker">{{ __('home.fields_kicker') }}</p>
            <h2 class="section-title mt-2">{{ __('home.fields_title') }}</h2>
            <p class="section-subtitle mx-auto max-w-2xl">{{ __('services.intro') }}</p>
        </div>

        <div class="mx-auto mt-12 grid w-full max-w-7xl grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-8 lg:grid-cols-4">
            @foreach($services as $i => $service)
                <div class="service-card reveal flex min-h-[340px] flex-col p-8 lg:min-h-[380px] lg:p-10" style="transition-delay: {{ $i * 60 }}ms">
                    <div class="icon-circle h-16 w-16 shrink-0">
                        <span class="text-xl font-bold">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-right-navy lg:text-2xl">{{ $service->title }}</h3>
                    <p class="mt-4 flex-1 text-base leading-relaxed text-right-gray line-clamp-5">{{ $service->description }}</p>
                    <a href="{{ locale_route('services') }}" class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-right-teal transition hover:text-right-teal-light">
                        {{ __('home.discover_more') }}
                        <span aria-hidden="true">←</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
