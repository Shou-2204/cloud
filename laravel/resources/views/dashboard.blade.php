<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-100 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- WELCOME HERO --}}
            <div class="mb-10 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight mb-4">
                    Bienvenue, <span
                        class="bg-clip-text text-transparent bg-gradient-to-r from-emerald-500 to-teal-400">{{ Auth::user()->name }}</span>.
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Gérez vos organisations, vos abonnements et accédez à tout votre univers ShouCloud depuis cet espace
                    unifié.
                </p>
            </div>

            {{-- NOTIFICATIONS --}}
            @if(Auth::user()->unreadNotifications->isNotEmpty())
                <div class="max-w-2xl mx-auto mb-10">
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 border-l-4 border-indigo-500 p-4 rounded-r-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3 w-full">
                                <h3 class="text-sm font-medium text-indigo-800 dark:text-indigo-200">
                                    Vous avez {{ Auth::user()->unreadNotifications->count() }} nouvelle(s) notification(s)
                                </h3>
                                <div class="mt-2 text-sm text-indigo-700 dark:text-indigo-300">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach(Auth::user()->unreadNotifications->take(3) as $notification)
                                            <li>
                                                <a href="{{ route('reviews.private') }}" class="underline hover:text-indigo-600 dark:hover:text-white">
                                                    {{ $notification->data['message'] ?? 'Nouvelle notification' }}
                                                </a>
                                                <span class="text-xs opacity-75 ml-2">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </span>
                                            </li>
                                        @endforeach
                                        @if(Auth::user()->unreadNotifications->count() > 3)
                                            <li class="list-none pt-1">
                                                <a href="{{ route('reviews.private') }}" class="font-medium hover:text-indigo-600 dark:hover:text-white">
                                                    Voir toutes les notifications &rarr;
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- SEARCH BAR --}}
            <div class="max-w-2xl mx-auto mb-16 relative z-20">
                <livewire:global-search />
            </div>

            {{-- DASHBOARD GRID (ALIGNED) --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                {{-- CARD 1: ACTIVE TEAM --}}
                <div
                    class="bg-white dark:bg-emerald-dark-500 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600 hover:shadow-md transition-all">
                    <div class="flex flex-col h-full justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Organisation</h3>
                            <div class="font-bold text-xl text-gray-900 dark:text-white truncate">
                                {{ Auth::user()->currentTeam ? Auth::user()->currentTeam->name : 'Aucune' }}
                            </div>
                        </div>
                        <div class="mt-4">
                            @if(Auth::user()->currentTeam)
                                <a href="{{ route('teams.show', Auth::user()->currentTeam) }}"
                                    class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                                    Gérer
                                </a>
                            @else
                                <a href="{{ route('teams.create') }}"
                                    class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                                    Créer
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CARD 2: PROFILE --}}
                <div
                    class="bg-white dark:bg-emerald-dark-500 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600 hover:shadow-md transition-all">
                    <div class="flex flex-col h-full justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Profil</h3>
                            <div class="font-bold text-xl text-gray-900 dark:text-white truncate">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('profile.show') }}"
                                class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                                Modifier
                            </a>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: OFFER --}}
                <div
                    class="bg-white dark:bg-emerald-dark-500 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600 hover:shadow-md transition-all">
                    <div class="flex flex-col h-full justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Offre</h3>
                            <div class="font-bold text-xl text-gray-900 dark:text-white">
                                @php
                                    $planName = 'Gratuit';
                                    if (Auth::user()->currentTeam && Auth::user()->currentTeam->subscribed()) {
                                        $subscription = Auth::user()->currentTeam->subscription();
                                        if ($subscription) {
                                            $priceId = $subscription->stripe_price;
                                            $plans = config('subscription_plans');
                                            foreach ($plans as $plan) {
                                                if ($plan['stripe_id_monthly'] === $priceId || $plan['stripe_id_yearly'] === $priceId) {
                                                    $planName = $plan['name'];
                                                    break;
                                                }
                                            }
                                        }
                                        // Fallback if generic subscription
                                        if ($planName === 'Gratuit') {
                                            $planName = 'Premium';
                                        }
                                    }
                                @endphp
                                {{ $planName }}
                            </div>
                        </div>
                        <div class="mt-4">
                            @if(Auth::user()->currentTeam && Auth::user()->currentTeam->subscribed())
                                <a href="{{ route('subscription.show', Auth::user()->currentTeam) }}"
                                    class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                                    Gérer
                                </a>
                            @else
                                <a href="{{ route('subscription.index') }}"
                                    class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                                    Passer Premium
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CARD 4: STATUS --}}
                <div
                    class="bg-white dark:bg-emerald-dark-500 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600 hover:shadow-md transition-all">
                    <div class="flex flex-col h-full justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Statut du compte</h3>
                            <div class="flex items-center gap-2">
                                <div class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                                <span class="font-bold text-xl text-gray-900 dark:text-white">Actif</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-xs text-gray-400">Tout fonctionne</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- REVIEWS CARD (for subscribed teams) --}}
            @if(Auth::user()->currentTeam && Auth::user()->currentTeam->subscribed())
                <div class="mt-8">
                    <a href="{{ route('reviews.stats') }}"
                        class="block bg-white dark:bg-emerald-dark-500 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600 hover:shadow-md transition-all group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-2xl">
                                    <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mes avis clients</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Consultez vos statistiques et
                                        feedbacks</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-500 transition-colors" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>