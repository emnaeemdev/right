<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.partners') }}</h1>
            <p class="section-subtitle reveal">{{ __('partners.intro') }}</p>
        </div>
    </section>

    @foreach(['intl', 'gov', 'ngo'] as $category)
        @if(isset($partners[$category]) && $partners[$category]->count())
            <section class="py-12 {{ $loop->even ? 'bg-right-offwhite' : 'bg-white' }}">
                <div class="mx-auto max-w-7xl px-4 lg:px-8">
                    <h2 class="reveal mb-8 text-2xl font-bold text-right-navy">{{ __('partners.' . $category) }}</h2>
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach($partners[$category] as $partner)
                            <article class="reveal group overflow-hidden rounded-sm bg-white shadow-sm transition hover:shadow-lg">
                                @if($partner->website)
                                    <a href="{{ $partner->website }}" target="_blank" rel="noopener noreferrer" class="block">
                                @endif
                                    <div class="aspect-[4/3] overflow-hidden bg-white">
                                        @if($partner->logo)
                                            <img src="{{ storage_url($partner->logo) }}"
                                                 alt="{{ $partner->name }}"
                                                 class="h-full w-full object-contain p-8 transition duration-300 group-hover:scale-[1.03]"
                                                 loading="lazy">
                                        @else
                                            <div class="flex h-full flex-col items-center justify-center gap-3 bg-gradient-to-br from-right-teal-muted/80 to-white p-8 text-center">
                                                <span class="flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl font-bold text-right-teal shadow-sm">
                                                    {{ mb_substr($partner->name, 0, 1) }}
                                                </span>
                                                <p class="text-sm text-right-gray">{{ __('home.partner_logo_pending') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="border-t border-right-teal/10 px-4 py-3 text-center">
                                        <h3 class="text-base font-semibold text-right-navy md:text-lg">{{ $partner->name }}</h3>
                                    </div>
                                @if($partner->website)
                                    </a>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach
</x-layout>
