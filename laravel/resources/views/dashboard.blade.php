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
                <div class="max-w-3xl mx-auto mb-12">
                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl shadow-lg shadow-orange-500/20">
                                <svg class="w-6 h-6 text-emerald-950 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Notifications
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ Auth::user()->unreadNotifications->count() }} en attente
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                            Nouveau
                        </span>
                    </div>

                    {{-- Notifications Cards --}}
                    <div class="space-y-3">
                        @foreach(Auth::user()->unreadNotifications->take(2) as $notification)
                            <a href="{{ $notification->data['url'] ?? '#' }}"
                               class="group block bg-white dark:bg-emerald-dark-500 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-emerald-dark-600 hover:shadow-lg hover:border-emerald-200 dark:hover:border-emerald-dark-500 transition-all duration-200 hover:-translate-y-0.5">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                            {{ $notification->data['message'] ?? 'Nouvelle notification' }}
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-300 dark:text-gray-600 group-hover:text-emerald-500 dark:group-hover:text-emerald-400 transition-colors ml-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- View All Link --}}
                    @if(Auth::user()->unreadNotifications->count() > 3)
                        <div class="mt-4 text-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                + {{ Auth::user()->unreadNotifications->count() - 3 }} autre(s) notification(s)
                            </span>
                        </div>
                    @endif
                </div>
            @endif

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