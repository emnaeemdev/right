<x-layout :meta="$meta">
    @include('components.home.hero', ['partners' => $partners])
    @include('components.home.statistics', ['stats' => $stats])
    @include('components.home.core-services', ['services' => $services])
    @include('components.home.featured-projects', ['projects' => $projects])
    @include('components.home.experts', ['experts' => $experts])
    @include('components.home.partners', ['partners' => $partners])
</x-layout>
