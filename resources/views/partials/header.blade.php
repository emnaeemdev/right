@php
    $navItems = [
        'home' => 'nav.home',
        'training-bags.index' => 'nav.training_bags',
        'papers.index' => 'nav.papers',
        'activities.index' => 'nav.activities',
        'quote-request' => 'nav.quote_request',
        'consulting' => 'nav.consulting',
        'services' => 'nav.services',
    ];

    $aboutMenuItems = [
        'about' => 'nav.about',
        'contact' => 'nav.contact',
    ];

    $aboutMenuActive = nav_is_active('about') || nav_is_active('contact');
@endphp

<header class="sticky top-0 z-50 bg-right-navy text-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 lg:px-8">
        <a href="{{ locale_route('home') }}" class="flex h-16 w-[250px] shrink-0 items-center" aria-label="{{ __('site.name') }}">
            <img src="{{ asset('images/logo_ar.jpeg') }}" alt="RIGHT Center" class="h-16 w-[250px] object-contain object-start" width="250" height="48" decoding="sync" fetchpriority="high">
        </a>

        <nav class="hidden items-center gap-5 xl:gap-6 lg:flex" aria-label="{{ __('nav.home') }}">
            @foreach($navItems as $route => $label)
                <a href="{{ locale_route($route) }}"
                   @class([
                       'nav-link whitespace-nowrap text-sm font-medium transition',
                       'nav-link-active' => nav_is_active($route),
                   ])>
                    {{ __($label) }}
                </a>
            @endforeach

            <div class="nav-dropdown group relative" data-nav-dropdown>
                <button type="button"
                        @class([
                            'nav-dropdown-toggle flex items-center gap-1 whitespace-nowrap py-1 text-sm font-medium transition',
                            'nav-link-active' => $aboutMenuActive,
                            'nav-link' => ! $aboutMenuActive,
                        ])
                        aria-expanded="false"
                        aria-haspopup="true">
                    {{ __('nav.about_right') }}
                    <svg class="nav-dropdown-chevron h-4 w-4 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="nav-dropdown-menu pointer-events-none invisible absolute top-full start-0 z-50 min-w-[11rem] pt-2 opacity-0 transition group-hover:pointer-events-auto group-hover:visible group-hover:opacity-100">
                    <div class="rounded-sm border border-white/10 bg-right-navy-light py-2 shadow-lg">
                        @foreach($aboutMenuItems as $route => $label)
                            <a href="{{ locale_route($route) }}"
                               @class([
                                   'block px-4 py-2 text-sm transition hover:bg-white/5 hover:text-right-teal-light',
                                   'nav-link-active !text-right-teal-light font-semibold' => nav_is_active($route),
                                   'text-white/80' => ! nav_is_active($route),
                               ])>
                                {{ __($label) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ alternate_locale_url() }}"
               class="rounded border border-white/20 px-3 py-1 text-xs font-medium transition hover:border-right-teal hover:text-right-teal-light"
               aria-label="Switch language">
                {{ app()->getLocale() === 'ar' ? 'EN' : 'AR' }}
            </a>

            <button id="mobile-nav-toggle" class="lg:hidden p-2" aria-expanded="false" aria-controls="mobile-nav-menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    <nav id="mobile-nav-menu" class="hidden border-t border-white/10 lg:hidden" aria-label="Mobile navigation">
        <div class="flex flex-col px-4 py-4">
            @foreach($navItems as $route => $label)
                <a href="{{ locale_route($route) }}"
                   @class([
                       'py-3 text-sm transition',
                       'nav-link-active font-semibold' => nav_is_active($route),
                       'text-white/80 hover:text-right-teal-light' => ! nav_is_active($route),
                   ])>
                    {{ __($label) }}
                </a>
            @endforeach

            <div class="border-t border-white/10 pt-3 mt-1">
                <button type="button"
                        id="mobile-about-toggle"
                        @class([
                            'flex w-full items-center justify-between py-3 text-sm font-medium',
                            'nav-link-active font-semibold' => $aboutMenuActive,
                            'text-white/80' => ! $aboutMenuActive,
                        ])
                        aria-expanded="false"
                        aria-controls="mobile-about-submenu">
                    {{ __('nav.about_right') }}
                    <svg class="h-4 w-4 transition" data-mobile-about-chevron fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="mobile-about-submenu" class="hidden ps-4">
                    @foreach($aboutMenuItems as $route => $label)
                        <a href="{{ locale_route($route) }}"
                           @class([
                               'block py-2 text-sm transition hover:text-right-teal-light',
                               'nav-link-active font-semibold' => nav_is_active($route),
                               'text-white/70' => ! nav_is_active($route),
                           ])>
                            {{ __($label) }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>
</header>
