<x-guest-layout :seo="$seo">
    {{-- JSON-LD FAQPage Schema --}}
    @php
        $faqItems = [];
        foreach ($faqCategories as $category) {
            foreach ($category['questions'] as $item) {
                $faqItems[] = [
                    '@type' => 'Question',
                    'name' => $item['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $item['answer'],
                    ],
                ];
            }
        }
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqItems,
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>

    <div class="pt-24 pb-16 bg-ivory dark:bg-emerald-dark min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="$seo['breadcrumbs']" />

            {{-- Hero Section --}}
            <div class="text-center mt-8 mb-12">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    Questions <span class="text-emerald-600 dark:text-emerald-400">Fréquentes</span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Tout ce que vous devez savoir sur InZeeCard et comment booster votre fidélisation client.
                </p>
            </div>

            {{-- FAQ Categories --}}
            <div class="space-y-8">
                @foreach($faqCategories as $category)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        {{-- Category Header --}}
                        <div class="bg-emerald-600 px-6 py-4">
                            <h2 class="text-xl font-bold text-white flex items-center gap-3">
                                @switch($category['icon'])
                                    @case('wrench-screwdriver')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        @break
                                    @case('chart-bar')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        @break
                                    @case('credit-card')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        @break
                                    @case('shield-check')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        @break
                                @endswitch
                                {{ $category['name'] }}
                            </h2>
                        </div>

                        {{-- Questions Accordion --}}
                        <div class="divide-y divide-gray-100 dark:divide-gray-700" x-data="{ openQuestion: null }">
                            @foreach($category['questions'] as $index => $item)
                                @php $questionId = Str::slug($category['name']) . '-' . $index; @endphp
                                <div class="group">
                                    <button
                                        @click="openQuestion = openQuestion === '{{ $questionId }}' ? null : '{{ $questionId }}'"
                                        class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                                    >
                                        <span class="font-semibold text-gray-900 dark:text-white text-lg">
                                            {{ $item['question'] }}
                                        </span>
                                        <span class="flex-shrink-0 text-emerald-500 transition-transform duration-200"
                                              :class="{ 'rotate-180': openQuestion === '{{ $questionId }}' }">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    <div
                                        x-show="openQuestion === '{{ $questionId }}'"
                                        x-collapse
                                        x-cloak
                                    >
                                        <div class="px-6 pb-6 pt-2">
                                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                                {{ $item['answer'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- CTA Section --}}
            <div class="mt-16 bg-white dark:bg-gray-800 rounded-2xl p-6 sm:p-12 text-center shadow-lg border border-gray-100 dark:border-gray-700">
                <div class="max-w-xl mx-auto">
                    @livewire('lead-capture', ['withDetails' => true])
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
