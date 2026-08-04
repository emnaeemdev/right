<section class="bg-right-navy py-20 text-white">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <h2 class="reveal text-center text-3xl font-bold md:text-4xl">{{ __('home.stats') }}</h2>
        <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach([
                ['projects', 'home.projects_count'],
                ['experts', 'home.experts_count'],
                ['partners', 'home.partners_count'],
                ['training_bags', 'home.bags_count'],
            ] as $i => [$key, $label])
                <div class="reveal text-center" style="transition-delay: {{ $i * 100 }}ms">
                    <div class="text-5xl font-bold text-right-teal-light" data-counter="{{ $stats[$key] ?? 0 }}">0</div>
                    <p class="mt-2 text-sm text-white/70">{{ __($label) }}</p>
                    <svg class="mx-auto mt-4 h-2 w-24" viewBox="0 0 96 8">
                        <rect width="96" height="8" rx="4" fill="#152A45"/>
                        <rect width="{{ min(96, ($stats[$key] ?? 0) * 1.5) }}" height="8" rx="4" fill="#349B9B"/>
                    </svg>
                </div>
            @endforeach
        </div>
    </div>
</section>
