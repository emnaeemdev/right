@foreach($sections as $section)
    <section @class(['py-16', 'bg-right-offwhite' => $loop->odd])>
        <div class="mx-auto max-w-5xl px-4 lg:px-8">
            @if($section['title'])
                <h2 @class([
                    'section-title reveal' => $section['type'] === 'rich',
                    'reveal text-xl font-bold text-right-navy' => $section['type'] !== 'rich',
                ])>{{ $section['title'] }}</h2>
            @endif

            @if($section['type'] === 'list' && count($section['items']))
                <ul class="mt-8 grid gap-3 sm:grid-cols-2">
                    @foreach($section['items'] as $item)
                        <li class="reveal flex items-start gap-3 rounded-sm border border-right-teal/10 bg-white p-4 text-sm text-right-navy">
                            <span class="mt-0.5 shrink-0 text-right-teal">✓</span>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            @elseif($section['type'] === 'text' && $section['body'])
                <p class="reveal mt-4 whitespace-pre-line text-right-gray">{{ $section['body'] }}</p>
            @elseif($section['type'] === 'rich' && $section['body'])
                <div class="rich-content reveal mt-8">
                    {!! $section['body'] !!}
                </div>
            @endif
        </div>
    </section>
@endforeach
