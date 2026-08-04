@props(['meta' => [], 'breadcrumbs' => []])

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $meta['title'] ?? __('site.name') }}</title>
    @if(!empty($meta['description']))
        <meta name="description" content="{{ $meta['description'] }}">
        <meta property="og:description" content="{{ $meta['description'] }}">
    @endif
    <meta property="og:title" content="{{ $meta['title'] ?? __('site.name') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'ar' ? 'ar_EG' : 'en_US' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="ar" href="{{ str_replace('/en', '', url()->current()) }}">
    <link rel="alternate" hreflang="en" href="{{ app()->getLocale() === 'en' ? url()->current() : url('en' . str_replace(url('/'), '', request()->getPathInfo() ?: '')) }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon.svg') }}" type="image/svg+xml">
    <link rel="preload" href="{{ asset('images/logo-white.svg') }}" as="image" type="image/svg+xml">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>
<body class="min-h-screen flex flex-col">
    @include('partials.header')

    @if(count($breadcrumbs))
        @include('partials.breadcrumb', ['items' => $breadcrumbs])
    @endif

    <main class="flex-1">
        {{ $slot }}
    </main>

    @include('partials.footer')
</body>
</html>
