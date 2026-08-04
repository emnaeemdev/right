<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-3xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.quote_request') }}</h1>
            <p class="section-subtitle reveal">{{ __('quote_request.intro') }}</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-2xl px-4 lg:px-8">
            <form action="{{ locale_route('quote.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="{{ __('forms.name') }}"
                       class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                <input type="text" name="organization" value="{{ old('organization') }}" placeholder="{{ __('forms.organization') }}"
                       class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="{{ __('forms.email') }}"
                       class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="{{ __('forms.phone') }}"
                       class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                <select name="training_bag_id" class="filter-select w-full">
                    <option value="">{{ __('quote_request.select_bag') }}</option>
                    @foreach($bags as $bag)
                        <option value="{{ $bag->id }}" @selected(old('training_bag_id') == $bag->id)>{{ $bag->title }}</option>
                    @endforeach
                </select>
                <textarea name="notes" rows="4" placeholder="{{ __('forms.notes') }}"
                          class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">{{ old('notes') }}</textarea>
                @if(session('success'))
                    <p class="text-sm text-right-teal">{{ session('success') }}</p>
                @endif
                @error('rate_limit')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                <x-simple-captcha form="quote" />
                <button type="submit" class="btn-primary w-full">{{ __('quote_request.submit') }}</button>
            </form>
        </div>
    </section>
</x-layout>
