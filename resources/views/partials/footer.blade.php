@php
    $footerLinks = [
        'home' => 'nav.home',
        'training-bags.index' => 'nav.training_bags',
        'papers.index' => 'nav.papers',
        'activities.index' => 'nav.activities',
        'quote-request' => 'nav.quote_request',
        'consulting' => 'nav.consulting',
        'services' => 'nav.services',
        'about' => 'nav.about_right',
    ];

    $serviceLinks = [
        'services' => 'nav.services',
        'training-bags.index' => 'nav.training_bags',
        'consulting' => 'nav.consulting',
        'papers.index' => 'nav.papers',
    ];
@endphp

<footer>
    {{-- Quick contact bar --}}
    <div class="bg-right-teal py-10 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
                <form action="{{ locale_route('contact.store') }}" method="POST" class="reveal space-y-3">
                    @csrf
                    <input type="hidden" name="subject" value="{{ __('footer.quick_contact_subject') }}">
                    <input type="hidden" name="message" value="{{ __('footer.quick_contact_message') }}">
                    <div class="grid gap-3 sm:grid-cols-4">
                        <input type="text" name="name" required placeholder="{{ __('forms.name') }}" class="footer-input">
                        <input type="tel" name="phone" placeholder="{{ __('forms.phone') }}" class="footer-input">
                        <input type="email" name="email" required placeholder="{{ __('forms.email') }}" class="footer-input">
                        <button type="submit" class="rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-right-teal transition hover:bg-right-teal-muted">
                            {{ __('contact.send') }}
                        </button>
                    </div>
                    <x-simple-captcha form="contact" class="max-w-xs [&_label]:text-white/90 [&_input]:border-white/20 [&_input]:bg-white/10 [&_input]:text-white [&_input]:placeholder:text-white/50" />
                    @if(session('success'))
                        <p class="text-sm text-white/90">{{ session('success') }}</p>
                    @endif
                </form>

                <div class="reveal flex items-center justify-center gap-4 lg:justify-end">
                    <div class="text-center lg:text-end">
                        <p class="text-sm font-semibold">WhatsApp</p>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', __('site.whatsapp')) }}"
                           class="mt-1 block text-lg font-bold hover:underline"
                           target="_blank"
                           rel="noopener noreferrer">
                            {{ __('site.whatsapp') }}
                        </a>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-right-green text-white">
                        <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 2C6.486 2 2 6.486 2 12c0 1.846.488 3.58 1.34 5.082L2 22l5.082-1.34A9.953 9.953 0 0012 22c5.514 0 10-4.486 10-10S17.514 2 12 2z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main footer --}}
    <div class="bg-right-dark py-14 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
            <div class="text-center">
    <img src="{{ asset('images/logo_ar.jpeg') }}"
         alt="RIGHT Center"
         class="mx-auto mb-4 h-16 w-auto">

    <p class="text-sm leading-relaxed text-white/60">
        {{ __('site.meta_description') }}
    </p>
</div>

                <div>
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-right-teal-light">{{ __('footer.quick_links') }}</h3>
                    <ul class="space-y-2 text-sm text-white/70">
                        @foreach($footerLinks as $route => $label)
                            <li>
                                <a href="{{ locale_route($route) }}" class="transition hover:text-white">{{ __($label) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-right-teal-light">{{ __('footer.main_services') }}</h3>
                    <ul class="space-y-2 text-sm text-white/70">
                        @foreach($serviceLinks as $route => $label)
                            <li>
                                <a href="{{ locale_route($route) }}" class="transition hover:text-white">{{ __($label) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-right-teal-light">{{ __('footer.contact_us') }}</h3>
                    <ul class="space-y-3 text-sm text-white/70">
                        <li class="flex items-start gap-2">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-right-teal-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ __('contact.address') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-4 w-4 shrink-0 text-right-teal-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <a href="tel:{{ preg_replace('/\s+/', '', __('site.phone')) }}" class="hover:text-white">{{ __('site.phone') }}</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-4 w-4 shrink-0 text-right-teal-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <a href="mailto:info@right-center.org" class="hover:text-white">info@right-center.org</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="h-4 w-4 shrink-0 text-right-teal-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9V3m0 18a9 9 0 009-9m-9 9a9 9 0 00-9-9"/></svg>
                            <a href="https://www.right-center.org" class="hover:text-white" target="_blank" rel="noopener noreferrer">www.right-center.org</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 border-t border-white/10 pt-6 text-center text-xs text-white/50">
                &copy; {{ date('Y') }} {{ __('site.name') }}. {{ __('home.rights') }}.
            </div>
        </div>
    </div>
</footer>
