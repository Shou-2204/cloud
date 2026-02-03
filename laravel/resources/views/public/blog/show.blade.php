<x-guest-layout :seo="$seo">
    <div class="pt-24 pb-12 bg-white dark:bg-gray-900 min-h-screen">
        <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="$seo['breadcrumbs']" />

            <header class="mb-12 text-center">
                <dl class="space-y-10">
                    <div>
                        <dt class="sr-only">Publié le</dt>
                        <dd class="text-base leading-6 font-medium text-emerald-600 dark:text-emerald-400">
                            <time datetime="2026-02-03">{{ $data['date'] }}</time>
                        </dd>
                    </div>
                </dl>
                <div>
                    <h1
                        class="text-3xl leading-9 font-extrabold text-gray-900 dark:text-white sm:text-4xl sm:leading-10 md:text-5xl md:leading-14">
                        {{ $data['title'] }}
                    </h1>
                </div>
            </header>

            <div class="prose prose-lg dark:prose-invert mx-auto mb-16">
                @php echo \Illuminate\Support\Str::markdown($data['content']) @endphp
            </div>

            <!-- Lead Capture Section -->
            <div
                class="bg-emerald-50 dark:bg-emerald-900/20 rounded-3xl p-8 sm:p-12 text-center border-2 border-emerald-100 dark:border-emerald-800">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-4">
                    Prêt à appliquer ces conseils de pro ?
                </h3>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                    Rejoignez plus de 500 commerçants qui utilisent {{ config('app.name') }} pour booster leur activité.
                </p>
                <div class="max-w-xl mx-auto">
                    @livewire('lead-capture')
                </div>
            </div>
        </article>
    </div>
</x-guest-layout>