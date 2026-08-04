<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.services') }}</h1>
            <p class="section-subtitle reveal">{{ __('services.intro') }}</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl space-y-6 px-4 lg:px-8">
            @foreach($services as $i => $service)
                <div class="reveal flex flex-col gap-6 border-b border-right-teal/10 pb-8 md:flex-row md:items-start">
                    <span class="text-4xl font-bold text-right-teal/30">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-right-navy">{{ $service->title }}</h2>
                        <p class="mt-4 text-right-gray">{{ $service->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-layout>
