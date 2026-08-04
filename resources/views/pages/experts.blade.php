<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.experts') }}</h1>
            <p class="section-subtitle reveal">{{ __('experts.intro') }}</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:grid-cols-2 lg:grid-cols-3 lg:px-8">
            @foreach($experts as $expert)
                <div class="reveal overflow-hidden rounded-sm border border-right-teal/10 bg-white">
                    <div class="aspect-[4/3] bg-right-teal-muted">
                        @if($expert->photo)
                            <img src="{{ storage_url($expert->photo) }}" alt="{{ $expert->name }}" class="h-full w-full object-cover" loading="lazy">
                        @else
                            <div class="flex h-full items-center justify-center text-5xl font-bold text-right-teal/20">{{ mb_substr($expert->name, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-right-navy">{{ $expert->name }}</h2>
                        <p class="mt-1 text-sm text-right-teal">{{ $expert->title }}</p>
                        <p class="mt-4 text-sm text-right-gray line-clamp-4">{{ $expert->bio }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-layout>
