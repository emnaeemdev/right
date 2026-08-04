@props(['items' => []])

@if(count($items))
<nav aria-label="Breadcrumb" class="border-b border-right-teal/10 bg-right-offwhite">
    <div class="mx-auto max-w-7xl px-4 py-3 lg:px-8">
        <ol class="flex flex-wrap items-center gap-2 text-sm text-right-gray">
            @foreach($items as $i => $item)
                <li class="flex items-center gap-2">
                    @if($i > 0)
                        <span class="text-right-teal/40" aria-hidden="true">/</span>
                    @endif
                    @if(!empty($item['url']) && !$loop->last)
                        <a href="{{ $item['url'] }}" class="transition hover:text-right-teal">{{ $item['label'] }}</a>
                    @else
                        <span class="font-medium text-right-navy" @if($loop->last) aria-current="page" @endif>{{ $item['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</nav>
@endif
