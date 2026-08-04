<x-layout :meta="$meta">
    @include('components.home.hero')
    @include('components.home.process-timeline')
    @include('components.home.core-services', ['services' => $services])
    @include('components.home.why-right')
    @include('components.home.statistics', ['stats' => $stats])
    @include('components.home.featured-projects', ['projects' => $projects])
    @include('components.home.experts', ['experts' => $experts])
    @include('components.home.partners', ['partners' => $partners])
    @include('components.home.post-support')
    @include('components.home.contact-cta')
</x-layout>
