@php
    $navItems = [
        'home' => 'nav.home',
        'training-bags.index' => 'nav.training_bags',
        'papers.index' => 'nav.papers',
        'activities.index' => 'nav.activities',
        'quote-request' => 'nav.quote_request',
        'consulting' => 'nav.consulting',
        'services' => 'nav.services',
        'about' => 'nav.about_right',
    ];
@endphp

<header class="sticky top-0 z-50 bg-white shadow-sm">
    {{-- Top bar --}}
    <div class="border-b border-right-teal/10 bg-right-offwhite">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2 text-xs lg:px-8">
            <div class="flex items-center gap-4">
                <a href="{{ alternate_locale_url() }}" class="top-bar-link font-semibold">
                    {{ app()->getLocale() === 'ar' ? 'EN' : 'AR' }}
                </a>
                <span class="hidden h-3 w-px bg-right-gray/30 sm:block" aria-hidden="true"></span>
                <a href="https://www.linkedin.com" target="_blank" rel="noopener noreferrer" class="top-bar-link hidden sm:inline" aria-label="LinkedIn">LinkedIn</a>
                <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" class="top-bar-link hidden sm:inline" aria-label="Facebook">Facebook</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="tel:{{ preg_replace('/\s+/', '', __('site.phone')) }}" class="top-bar-link font-medium">
                    {{ __('site.phone') }}
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', __('site.whatsapp')) }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center gap-1 rounded-full bg-right-green px-2.5 py-1 text-[11px] font-semibold text-white">
                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 2C6.486 2 2 6.486 2 12c0 1.846.488 3.58 1.34 5.082L2 22l5.082-1.34A9.953 9.953 0 0012 22c5.514 0 10-4.486 10-10S17.514 2 12 2z"/></svg>
                    WhatsApp
                </a>
            </div>
        </div>
    </div>

    {{-- Main nav --}}
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 lg:px-8">
    <a href="{{ locale_route('home') }}"
   class="flex shrink-0 items-center justify-center"
   aria-label="{{ __('site.name') }}">
    <img src="{{ asset('images/logo_ar.jpeg') }}"
         alt="RIGHT Center"
         class="h-16 w-28 object-contain md:h-18 md:w-32"
         decoding="sync"
         fetchpriority="high">
</a>

        <nav class="hidden items-center gap-4 xl:gap-5 lg:flex" aria-label="{{ __('nav.home') }}">
            @foreach($navItems as $route => $label)
                <a href="{{ locale_route($route) }}"
                   @class([
                       'site-nav-link',
                       'site-nav-link-active' => nav_is_active($route),
                   ])>
                    {{ __($label) }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ locale_route('consulting') }}" class="btn-primary-sm hidden sm:inline-flex">
                {{ __('home.request_consultation') }}
            </a>

            <button id="mobile-nav-toggle" class="rounded-lg p-2 text-right-navy lg:hidden" aria-expanded="false" aria-controls="mobile-nav-menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    <nav id="mobile-nav-menu" class="hidden border-t border-right-teal/10 lg:hidden" aria-label="Mobile navigation">
        <div class="flex flex-col px-4 py-4">
            @foreach($navItems as $route => $label)
                <a href="{{ locale_route($route) }}"
                   @class([
                       'py-3 text-base transition',
                       'site-nav-link-active font-semibold' => nav_is_active($route),
                       'text-right-navy/80 hover:text-right-teal' => ! nav_is_active($route),
                   ])>
                    {{ __($label) }}
                </a>
            @endforeach
            <a href="{{ locale_route('consulting') }}" class="btn-primary mt-4 text-center">{{ __('home.request_consultation') }}</a>
        </div>
    </nav>
</header>
