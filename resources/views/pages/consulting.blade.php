<x-layout :meta="$meta" :breadcrumbs="$breadcrumbs">
    <section class="bg-right-offwhite py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="section-title reveal">{{ __('nav.consulting') }}</h1>
            <p class="section-subtitle reveal">{{ __('consulting.intro') }}</p>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 lg:grid-cols-2 lg:px-8">
            <div class="reveal space-y-4">
                @foreach($types as $key => $label)
                    <div class="flex items-start gap-3 border-b border-right-teal/10 pb-4">
                        <span class="text-right-teal font-bold">✓</span>
                        <span class="text-right-navy">{{ $label }}</span>
                    </div>
                @endforeach
            </div>

            <form action="{{ locale_route('consulting.store') }}" method="POST" class="reveal space-y-4">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="{{ __('forms.name') }}"
                       class="w-full rounded-sm border border-right-teal/20 px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                <input type="text" name="organization" value="{{ old('organization') }}" placeholder="{{ __('forms.organization') }}"
                       class="w-full rounded-sm border border-right-teal/20 px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="{{ __('forms.email') }}"
                       class="w-full rounded-sm border border-right-teal/20 px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="{{ __('forms.phone') }}"
                       class="w-full rounded-sm border border-right-teal/20 px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                <select name="consultation_type" required class="w-full rounded-sm border border-right-teal/20 px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                    <option value="">{{ __('forms.consultation_type') }}</option>
                    @foreach($types as $key => $label)
                        <option value="{{ $key }}" @selected(old('consultation_type') == $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <textarea name="description" required rows="4" placeholder="{{ __('forms.description') }}"
                          class="w-full rounded-sm border border-right-teal/20 px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">{{ old('description') }}</textarea>
                <input type="text" name="budget_range" value="{{ old('budget_range') }}" placeholder="{{ __('forms.budget_range') }}"
                       class="w-full rounded-sm border border-right-teal/20 px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
                @if(session('success'))
                    <p class="text-sm text-right-teal">{{ session('success') }}</p>
                @endif
                @error('rate_limit')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                <x-simple-captcha form="consulting" />
                <button type="submit" class="btn-primary">{{ __('consulting.submit') }}</button>
            </form>
        </div>
    </section>
</x-layout>
