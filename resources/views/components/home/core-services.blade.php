<section class="bg-right-offwhite py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <h2 class="section-title reveal">{{ __('nav.services') }}</h2>
        <p class="section-subtitle reveal">{{ __('services.intro') }}</p>

        <div class="mt-12 grid gap-4 md:grid-cols-4 md:grid-rows-2">
            @foreach($services as $i => $service)
                <div @class([
                    'reveal rounded-sm border border-right-teal/10 bg-white p-6 transition hover:border-right-teal/30 hover:shadow-sm',
                    'md:col-span-2 md:row-span-2' => $i === 0,
                    'md:col-span-2' => $i === 1,
                ]) style="transition-delay: {{ $i * 80 }}ms">
                    <span class="text-2xl font-bold text-right-teal">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="mt-3 text-lg font-semibold text-right-navy">{{ $service->title }}</h3>
                    <p class="mt-2 text-sm text-right-gray line-clamp-3">{{ $service->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
