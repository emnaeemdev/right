@php
    $partnerCategories = collect(['intl', 'gov', 'ngo'])->filter(
        fn (string $cat): bool => $partners->where('category', $cat)->isNotEmpty(),
    );
    $defaultPartnerTab = $partnerCategories->first() ?? 'gov';
@endphp

<section class="border-y border-right-teal/10 bg-right-offwhite py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
            <div class="reveal max-w-2xl">
                <p class="text-sm font-semibold tracking-wide text-right-teal">{{ __('home.partners_kicker') }}</p>
                <h2 class="section-title mt-2">{{ __('home.our_partners') }}</h2>
                <p class="mt-4 text-base leading-relaxed text-right-gray md:text-lg">{{ __('home.partners_subtitle') }}</p>
            </div>
            <a href="{{ locale_route('partners') }}"
               class="reveal btn-outline shrink-0 self-start lg:self-auto">
                {{ __('home.view_all') }}
            </a>
        </div>

        @if($partnerCategories->isNotEmpty())
            <div class="content-tabs reveal mt-10 flex flex-wrap gap-2" role="tablist" aria-label="{{ __('home.our_partners') }}">
                @foreach($partnerCategories as $cat)
                    <button type="button"
                            @class(['content-tab', 'is-active' => $cat === $defaultPartnerTab])
                            role="tab"
                            aria-selected="{{ $cat === $defaultPartnerTab ? 'true' : 'false' }}"
                            aria-controls="partners-panel-{{ $cat }}"
                            data-content-tab="{{ $cat }}">
                        {{ __('partners.' . $cat) }}
                        <span class="ms-1.5 text-xs opacity-80">({{ $partners->where('category', $cat)->count() }})</span>
                    </button>
                @endforeach
            </div>

            @foreach($partnerCategories as $cat)
                <div id="partners-panel-{{ $cat }}"
                     @class([
                         'content-panel mt-10',
                         'is-active' => $cat === $defaultPartnerTab,
                         'hidden' => $cat !== $defaultPartnerTab,
                     ])
                     role="tabpanel"
                     data-content-panel="{{ $cat }}">
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($partners->where('category', $cat) as $partner)
                            @php
                                $partnerUrl = $partner->website;
                            @endphp
                            <article class="reveal group overflow-hidden rounded-sm bg-white shadow-sm transition duration-300 hover:shadow-lg">
                                @if($partnerUrl)
                                    <a href="{{ $partnerUrl }}" target="_blank" rel="noopener noreferrer" class="block">
                                @endif
                                    <div class="aspect-[4/3] overflow-hidden bg-white">
                                        @if($partner->logo)
                                            <img src="{{ storage_url($partner->logo) }}"
                                                 alt="{{ $partner->name }}"
                                                 class="h-full w-full object-contain p-8 transition duration-300 group-hover:scale-[1.03] md:p-10"
                                                 loading="lazy">
                                        @else
                                            <div class="flex h-full flex-col items-center justify-center gap-3 bg-gradient-to-br from-right-teal-muted/80 to-white p-8 text-center">
                                                <span class="flex h-20 w-20 items-center justify-center rounded-full bg-white text-3xl font-bold text-right-teal shadow-sm">
                                                    {{ mb_substr($partner->name, 0, 1) }}
                                                </span>
                                                <p class="text-sm text-right-gray">{{ __('home.partner_logo_pending') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="border-t border-right-teal/10 px-5 py-4 text-center">
                                        <h3 class="text-lg font-semibold leading-snug text-right-navy md:text-xl">
                                            {{ $partner->name }}
                                        </h3>
                                    </div>
                                @if($partnerUrl)
                                    </a>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</section>
