<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.contact') }}</h1>
            <p class="section-subtitle reveal">{{ __('contact.intro') }}</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 lg:grid-cols-2 lg:px-8">
            <div class="reveal space-y-6">
                <div>
                    <h2 class="font-semibold text-right-navy">{{ __('contact.address') }}</h2>
                    <p class="mt-2 text-right-gray">{{ __('contact.address') }}</p>
                </div>
                <div>
                    <h2 class="font-semibold text-right-navy">{{ __('contact.email') }}</h2>
                    <p class="mt-2 text-right-teal">info@right-center.org</p>
                </div>
                <div>
                    <h2 class="font-semibold text-right-navy">{{ __('contact.phone') }}</h2>
                    <p class="mt-2 text-right-gray" dir="ltr">+20 2 0000 0000</p>
                </div>
            </div>

            <div class="reveal rounded-sm border border-right-teal/10 bg-white p-6 lg:p-8">
                <x-contact-form />
            </div>
        </div>
    </section>
</x-layout>
