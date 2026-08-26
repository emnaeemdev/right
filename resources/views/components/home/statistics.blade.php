<section class="relative z-10 -mt-16 pb-8">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
            @foreach([
                ['years', 'home.stat_years', 'heroicon-o-clock'],
                ['organizations', 'home.stat_organizations', 'heroicon-o-building-office-2'],
                ['partners', 'home.stat_partners', 'heroicon-o-globe-alt'],
                ['experts', 'home.stat_experts', 'heroicon-o-user-group'],
            ] as $i => [$key, $label, $icon])
                <div class="stat-card">
                    <div class="icon-circle mb-4">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            @if($key === 'years')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @elseif($key === 'organizations')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/>
                            @elseif($key === 'partners')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9 9 0 100-18 9 9 0 000 18zM2.05 13h19.9M12 2.05v19.9"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            @endif
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-right-teal">+{{ $stats[$key] ?? 0 }}</div>
                    <p class="mt-2 text-sm font-medium text-right-gray">{{ __($label) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
