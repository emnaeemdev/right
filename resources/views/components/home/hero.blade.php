<section class="relative overflow-hidden bg-right-offwhite">
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-20 lg:grid-cols-2 lg:px-8 lg:py-32">
        <div class="hero-text">
            <h1 class="text-4xl font-bold leading-tight text-right-navy md:text-5xl lg:text-6xl">
                {{ __('site.name') }}
            </h1>
            <div class="mt-4 h-px w-16 bg-right-teal"></div>
            <p class="mt-4 text-sm font-light tracking-widest text-right-gray uppercase">
                {{ __('site.tagline') }}
            </p>
            <p class="mt-6 max-w-lg text-lg text-right-gray">
                {{ __('site.meta_description') }}
            </p>
            <a href="{{ locale_route('services') }}" class="btn-primary mt-8">
                {{ __('home.explore_services') }}
            </a>
        </div>

        <div class="relative flex items-center justify-center">
            <div class="absolute inset-0 opacity-5"
                 style="background-image: linear-gradient(#349B9B 1px, transparent 1px), linear-gradient(90deg, #349B9B 1px, transparent 1px); background-size: 40px 40px;">
            </div>
            <div class="relative flex flex-col items-center">
                <img src="{{ asset('images/right_logo1.png') }}" alt="RIGHT Center" class="h-auto w-full max-w-xs md:max-w-sm">
                <svg viewBox="0 0 200 60" class="absolute -top-4 -end-4 h-16 w-16 md:h-20 md:w-20" aria-hidden="true">
                    <path id="hero-check-path" d="M20 40 L40 55 L80 10" stroke="#349B9B" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
            </div>
        </div>
    </div>
</section>
