<section id="process-timeline" class="bg-right-white py-20">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <h2 class="section-title reveal text-center">{{ __('home.process') }}</h2>
        <div class="relative mt-16">
            <div class="absolute top-8 start-0 end-0 hidden h-0.5 border-t-2 border-dashed border-right-navy/20 md:block"></div>
            <div id="timeline-progress" class="absolute top-8 start-0 hidden h-0.5 w-full origin-left bg-right-teal md:block" style="transform: scaleX(0)"></div>
            <div class="grid gap-8 md:grid-cols-4">
                @foreach([
                    ['step_1', 'step_1_desc'],
                    ['step_2', 'step_2_desc'],
                    ['step_3', 'step_3_desc'],
                    ['step_4', 'step_4_desc'],
                ] as $i => [$title, $desc])
                    <div class="reveal text-center" style="transition-delay: {{ $i * 100 }}ms">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full border-2 border-right-teal bg-right-teal-muted text-xl font-bold text-right-teal">
                            ✓
                        </div>
                        <h3 class="mt-4 font-semibold text-right-navy">{{ __('home.' . $title) }}</h3>
                        <p class="mt-2 text-sm text-right-gray">{{ __('home.' . $desc) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
