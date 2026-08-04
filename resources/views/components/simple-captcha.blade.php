@props(['form' => 'contact'])

@php($captcha = \App\Support\SimpleCaptcha::refresh($form))

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    <label for="captcha-{{ $form }}" class="block text-sm font-medium text-right-navy">
        {{ $captcha['question'] }}
    </label>
    <input type="hidden" name="captcha_key" value="{{ $captcha['key'] }}">
    <input type="number"
           id="captcha-{{ $form }}"
           name="captcha_answer"
           value="{{ old('captcha_answer') }}"
           required
           inputmode="numeric"
           autocomplete="off"
           placeholder="{{ __('forms.captcha_placeholder') }}"
           class="w-full rounded-sm border border-right-teal/20 bg-white px-4 py-3 text-sm focus:border-right-teal focus:outline-none focus:ring-1 focus:ring-right-teal">
    @error('captcha')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
