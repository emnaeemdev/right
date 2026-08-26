<section class="hero-section">
    {{-- Full-width background pattern (circles span entire section, not the image) --}}
    <div class="hero-section__pattern" aria-hidden="true">
        <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
            <rect width="100%" height="100%" fill="#EDE9FE"/>
            <circle cx="88%" cy="12%" r="220" fill="#FFFFFF" fill-opacity="0.55"/>
            <circle cx="72%" cy="38%" r="140" fill="#FFFFFF" fill-opacity="0.35"/>
            <circle cx="95%" cy="62%" r="180" fill="#FFFFFF" fill-opacity="0.3"/>
            <circle cx="12%" cy="18%" r="190" fill="#FFFFFF" fill-opacity="0.45"/>
            <circle cx="28%" cy="55%" r="260" fill="#FFFFFF" fill-opacity="0.38"/>
            <circle cx="5%" cy="78%" r="160" fill="#FFFFFF" fill-opacity="0.32"/>
            <circle cx="50%" cy="8%" r="90" fill="#FFFFFF" fill-opacity="0.28"/>
            <circle cx="42%" cy="82%" r="120" fill="#FFFFFF" fill-opacity="0.25"/>
            <circle cx="65%" cy="88%" r="100" fill="#FFFFFF" fill-opacity="0.22"/>
            <circle cx="18%" cy="42%" r="70" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-opacity="0.45"/>
            <circle cx="58%" cy="28%" r="55" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-opacity="0.35"/>
            <circle cx="78%" cy="72%" r="65" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-opacity="0.3"/>
            {{-- Quarter-circle accents --}}
            <path d="M0 100% L0 55% A45% 45% 0 0 1 45% 100% Z" fill="#FFFFFF" fill-opacity="0.28"/>
            <path d="M100% 0 L55% 0 A35% 35% 0 0 0 100% 35% Z" fill="#FFFFFF" fill-opacity="0.22"/>
        </svg>
    </div>

    <div class="hero-section__content relative mx-auto grid max-w-7xl items-center gap-8 px-4 py-14 lg:grid-cols-2 lg:gap-10 lg:px-8 lg:py-16 min-h-[70vh] lg:min-h-[88vh]">
        <div class="relative z-10 flex items-center justify-center">
            <img src="{{ asset('images/hero-illustration.png') }}"
                 alt="{{ __('home.hero_image_alt') }}"
                 class="w-full max-w-lg object-contain lg:max-w-xl"
                 width="800"
                 height="600"
                 loading="eager"
                 decoding="async">
        </div>

        <div class="hero-text relative z-10">
            <p class="text-sm font-semibold text-[#5B21B6]">{{ __('home.hero_kicker') }}</p>
            <h1 class="mt-3 text-4xl font-bold leading-tight text-[#1E1B4B] md:text-5xl lg:text-[3rem]">
                {{ __('home.hero_title') }}
            </h1>
            <p class="mt-4 text-xl font-semibold text-[#4338CA] md:text-2xl">
                {{ __('home.hero_subtitle') }}
            </p>
            <p class="mt-5 max-w-xl text-base leading-relaxed text-right-gray md:text-lg">
                {{ __('home.hero_description') }}
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ locale_route('consulting') }}" class="btn-primary">
                    {{ __('home.hero_cta_primary') }}
                </a>
                <a href="{{ locale_route('services') }}" class="btn-outline bg-white/60">
                    {{ __('home.hero_cta_secondary') }}
                </a>
            </div>

            <div class="mt-10">
                <p class="text-xs font-medium uppercase tracking-wider text-right-gray">{{ __('home.trusted_by') }}</p>
                <div class="partners-marquee mt-4 opacity-80">
                    @foreach($partners->take(6) as $partner)
                        @if($partner->logo)
                            <img src="{{ storage_url($partner->logo) }}"
                                 alt="{{ $partner->name }}"
                                 class="h-8 w-auto max-w-[100px] object-contain"
                                 loading="lazy">
                        @else
                            <span class="text-xs font-semibold text-right-gray">{{ $partner->name }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
