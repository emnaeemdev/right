<section class="border-y border-right-teal/10 bg-right-offwhite py-12">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <p class="reveal mb-6 text-center text-sm font-semibold uppercase tracking-wider text-right-gray">
            {{ __('home.our_partners') }}
        </p>
        <div class="partners-marquee reveal justify-center">
            @forelse($partners as $partner)
                @if($partner->logo)
                    <img src="{{ storage_url($partner->logo) }}"
                         alt="{{ $partner->name }}"
                         class="h-10 w-auto max-w-[120px] shrink-0 object-contain md:h-12"
                         loading="lazy">
                @else
                    <span class="shrink-0 text-sm font-semibold text-right-gray">{{ $partner->name }}</span>
                @endif
            @empty
                <p class="text-sm text-right-gray">{{ __('home.partner_logo_pending') }}</p>
            @endforelse
        </div>
    </div>
</section>
