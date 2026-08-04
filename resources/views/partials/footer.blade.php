@php
    $footerLinks = [
        'home' => 'nav.home',
        'training-bags.index' => 'nav.training_bags',
        'papers.index' => 'nav.papers',
        'activities.index' => 'nav.activities',
        'quote-request' => 'nav.quote_request',
        'consulting' => 'nav.consulting',
        'services' => 'nav.services',
        'about' => 'nav.about',
        'contact' => 'nav.contact',
    ];
@endphp

<footer class="bg-right-navy text-white">
    <div class="section-divider bg-right-teal"></div>
    <div class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
        <div class="grid gap-8 md:grid-cols-3">
            <div class="text-center">
                <img src="{{ asset('images/logo_ar.jpeg') }}"
                     alt="RIGHT Center"
                     class="mx-auto mb-4 h-16 w-[240px] object-contain object-center"
                     decoding="sync">
                <p class="text-sm text-white/60">{{ __('site.tagline') }}</p>
            </div>
            <div>
                <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-right-teal-light">{{ __('footer.quick_links') }}</h3>
                <ul class="space-y-2 text-sm text-white/70">
                    @foreach($footerLinks as $route => $label)
                        <li>
                            <a href="{{ locale_route($route) }}" class="transition hover:text-right-teal-light">{{ __($label) }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-right-teal-light">{{ __('footer.contact_us') }}</h3>
                <p class="text-sm text-white/70">{{ __('contact.address') }}</p>
                <p class="mt-2 text-sm text-white/70">
                    <a href="mailto:info@right-center.org" class="transition hover:text-right-teal-light">info@right-center.org</a>
                </p>
                <p class="mt-4">
                    <a href="{{ locale_route('contact') }}" class="text-sm font-medium text-right-teal-light transition hover:text-white">{{ __('footer.contact_form') }} →</a>
                </p>
            </div>
        </div>
        <div class="section-divider my-8 bg-right-teal/30"></div>
        <p class="text-center text-xs text-white/50">
            &copy; {{ date('Y') }} {{ __('site.name') }}. {{ __('home.rights') }}.
        </p>
    </div>
</footer>
