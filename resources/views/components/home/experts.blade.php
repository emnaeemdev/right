<section class="bg-right-white py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <div class="flex items-end justify-between">
            <h2 class="section-title reveal">{{ __('home.our_experts') }}</h2>
            <a href="{{ locale_route('experts') }}" class="reveal text-sm font-medium text-right-teal hover:text-right-teal-light">
                {{ __('home.view_all') }} →
            </a>
        </div>

        <div class="mt-12 flex gap-6 overflow-x-auto pb-4 snap-x">
            @foreach($experts as $expert)
                <div class="reveal w-64 shrink-0 snap-start">
                    <div class="aspect-[3/4] overflow-hidden rounded-sm bg-right-teal-muted">
                        @if($expert->photo)
                            <img src="{{ storage_url($expert->photo) }}" alt="{{ $expert->name }}" class="h-full w-full object-cover" loading="lazy">
                        @else
                            <div class="flex h-full items-center justify-center text-4xl font-bold text-right-teal/30">
                                {{ mb_substr($expert->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="mt-4 font-semibold text-right-navy">{{ $expert->name }}</h3>
                    <p class="text-sm text-right-teal">{{ $expert->title }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
