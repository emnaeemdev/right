@props(['compact' => false])

<form action="{{ locale_route('contact.store') }}" method="POST" {{ $attributes->merge(['class' => 'space-y-4']) }}>
    @csrf
    <div @class(['grid gap-4', 'sm:grid-cols-2' => ! $compact])>
        <input type="text" name="name" value="{{ old('name') }}" required placeholder="{{ __('forms.name') }}"
               class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
        <input type="email" name="email" value="{{ old('email') }}" required placeholder="{{ __('forms.email') }}"
               class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
    </div>
    @unless($compact)
        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="{{ __('forms.phone') }}"
               class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
        <input type="text" name="subject" value="{{ old('subject') }}" placeholder="{{ __('forms.subject') }}"
               class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
    @endunless
    <textarea name="message" required rows="{{ $compact ? 3 : 5 }}" placeholder="{{ __('forms.message') }}"
              class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">{{ old('message') }}</textarea>
    @if(session('success'))
        <p class="text-sm text-right-teal">{{ session('success') }}</p>
    @endif
    @error('rate_limit')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
    <x-simple-captcha form="contact" />
    <button type="submit" class="btn-primary {{ $compact ? 'w-full sm:w-auto' : '' }}">{{ __('contact.send') }}</button>
</form>
