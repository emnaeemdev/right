<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <div class="flex items-end justify-between gap-4">
            <div class="reveal">
                <p class="section-kicker">{{ __('home.team_kicker') }}</p>
                <h2 class="section-title mt-2">{{ __('home.our_experts') }}</h2>
            </div>
            <a href="{{ locale_route('experts') }}" class="reveal text-sm font-semibold text-right-teal hover:text-right-teal-light">
                {{ __('home.view_all') }} ←
            </a>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($experts->take(4) as $i => $expert)
                <article class="team-card reveal" style="transition-delay: {{ $i * 80 }}ms">
                    <div class="mx-auto h-28 w-28 overflow-hidden rounded-full bg-right-teal-muted ring-4 ring-right-teal/10">
                        @if($expert->photo)
                            <img src="{{ storage_url($expert->photo) }}" alt="{{ $expert->name }}" class="h-full w-full object-cover" loading="lazy">
                        @else
                            <div class="flex h-full items-center justify-center text-3xl font-bold text-right-teal">
                                {{ mb_substr($expert->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-right-navy">{{ $expert->name }}</h3>
                    <p class="mt-1 text-sm font-medium text-right-teal">{{ $expert->title }}</p>
                    @if($expert->bio)
                        <p class="mt-3 text-sm leading-relaxed text-right-gray line-clamp-3">{{ $expert->bio }}</p>
                    @endif
                    @if($expert->email)
                        <a href="mailto:{{ $expert->email }}" class="mt-4 inline-flex text-right-gray transition hover:text-right-teal" aria-label="{{ __('contact.email') }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </a>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
