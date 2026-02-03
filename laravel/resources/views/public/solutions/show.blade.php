<x-guest-layout :seo="$seo">
    <div class="pt-24 pb-12 bg-white dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="$seo['breadcrumbs']" />

            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center mt-12">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl mb-6">
                        {{ $data['title'] }}
                    </h1>
                    <div class="prose prose-lg dark:prose-invert text-gray-600 dark:text-gray-300 mb-8">
                        <p>{{ $data['description'] }}</p>
                        <h3 class="text-xl font-bold mt-6 mb-4">Pourquoi choisir notre solution :</h3>
                        <ul class="space-y-4">
                            @foreach($data['features'] as $title => $desc)
                                <li>
                                    <strong class="text-emerald-600 dark:text-emerald-400">{{ $title }}</strong> :
                                    {{ $desc }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-8">
                        <p class="text-sm font-bold text-emerald-800 dark:text-emerald-200 mb-4">Rejoignez les
                            commerçants qui réussissent :</p>
                        @livewire('lead-capture')
                    </div>
                </div>
                <div class="mt-12 lg:mt-0 relative">
                    <div
                        class="relative bg-emerald-50 dark:bg-emerald-900/20 rounded-3xl p-8 h-96 flex items-center justify-center border-2 border-dashed border-emerald-200 dark:border-emerald-800">
                        <div class="text-center">
                            <svg class="w-24 h-24 text-emerald-500 mx-auto mb-4 opacity-50" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                @if($slug === 'restaurants')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                @elseif($slug === 'retail')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                @endif
                            </svg>
                            <span
                                class="text-emerald-800 dark:text-emerald-200 font-bold block mt-2">{{ ucfirst($slug) }}
                                Boost</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specific Features Section -->
            <section class="mt-24">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-12 text-center">Pourquoi les meilleurs
                    établissements en {{ $slug }} nous choisissent</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature Cards Placeholder -->
                    <div
                        class="p-6 bg-slate-50 dark:bg-emerald-dark-500 rounded-xl border border-gray-100 dark:border-emerald-dark-400">
                        <h3 class="font-bold text-xl mb-2 dark:text-white">Automatisation d'Avis</h3>
                        <p class="text-gray-600 dark:text-gray-400">Collectez automatiquement des avis 5 étoiles sur
                            Google dès le paiement.</p>
                    </div>
                    <div
                        class="p-6 bg-slate-50 dark:bg-emerald-dark-500 rounded-xl border border-gray-100 dark:border-emerald-dark-400">
                        <h3 class="font-bold text-xl mb-2 dark:text-white">Base de Données Client</h3>
                        <p class="text-gray-600 dark:text-gray-400">Construisez votre liste de clients automatiquement
                            et sans effort.</p>
                    </div>
                    <div
                        class="p-6 bg-slate-50 dark:bg-emerald-dark-500 rounded-xl border border-gray-100 dark:border-emerald-dark-400">
                        <h3 class="font-bold text-xl mb-2 dark:text-white">Campagnes SMS/Email</h3>
                        <p class="text-gray-600 dark:text-gray-400">Faites revenir vos clients lors de vos journées
                            calmes avec des offres ciblées.</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-guest-layout>