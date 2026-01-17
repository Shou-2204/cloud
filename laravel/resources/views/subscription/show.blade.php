<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Mon Abonnement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            {{-- PLAN ACTUEL --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-[var(--gray900)] shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Plan Actuel') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Détails de l\'offre souscrite pour l\'équipe') }} <span
                                    class="font-bold text-gray-900 dark:text-white">{{ $team->name }}</span>.
                            </p>
                        </header>

                        <div class="mt-6">
                            {{-- NEW LAYOUT: Header with Plan Name + Status/Button --}}
                            <div
                                class="flex items-center justify-between p-6 bg-gray-50 dark:bg-[var(--primary-black)] rounded-xl">
                                <div>
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Votre Offre
                                    </div>
                                    <div class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400">
                                        {{ $planName }}
                                    </div>

                                    {{-- Subtitles / Dates --}}
                                    @if ($subscription->onGracePeriod())
                                        <div class="text-sm text-yellow-600 dark:text-yellow-400 mt-2 font-medium">
                                            Fin de l'abonnement le {{ $subscription->ends_at->format('d/m/Y') }}
                                        </div>
                                    @elseif ($subscription->active())
                                        @php
                                            $stripeSubscription = $subscription->asStripeSubscription();
                                            $currentPeriodEnd = $stripeSubscription->current_period_end ?? null;
                                        @endphp
                                        @if($currentPeriodEnd)
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                                Renouvellement le
                                                {{ \Carbon\Carbon::createFromTimestamp($currentPeriodEnd)->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    @endif
                                </div>

                                {{-- ACTION AREA --}}
                                <div>
                                    @if ($subscription->onGracePeriod())
                                        <a href="{{ route('subscription.resume', $team) }}"
                                            class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all">
                                            {{ __('Réactiver maintenant') }}
                                        </a>
                                    @elseif ($subscription->active())
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('subscription.index') }}"
                                                class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300">
                                                {{ __('Changer d\'offre') }}
                                            </a>
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                                                {{ __('Actif') }}
                                            </span>
                                        </div>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                            {{ __('Inactif') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Additional messages if needed --}}
                            @if (!$subscription->active() && !$subscription->onGracePeriod())
                                <div class="mt-4 text-center">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        {{ __('Votre abonnement est arrivé à expiration.') }}
                                    </p>
                                    <a href="{{ route('subscription.index') }}"
                                        class="text-emerald-600 font-medium hover:underline">Voir les offres</a>
                                </div>
                            @endif
                        </div>
                    </section>
                </div>
            </div>

            {{-- FACTURATION --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-[var(--gray900)] shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Informations de Facturation') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Ces informations apparaîtront sur vos futures factures.') }}
                        </p>
                    </header>

                    <form method="POST" action="{{ route('subscription.update-billing', $team) }}"
                        class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-label for="billing_name" value="{{ __('Nom de facturation / Entreprise') }}" />
                            <x-input id="billing_name" name="billing_name" type="text" class="mt-1 block w-full"
                                :value="old('billing_name', $team->billing_name)" required />
                            <x-input-error for="billing_name" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-label for="billing_address" value="{{ __('Adresse ligne 1') }}" />
                                <x-input id="billing_address" name="billing_address" type="text"
                                    class="mt-1 block w-full" :value="old('billing_address', $team->billing_address)"
                                    required placeholder="123 Rue de la Paix" />
                                <x-input-error for="billing_address" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-label for="billing_address_line2" value="{{ __('Adresse ligne 2 (Optionnel)') }}" />
                                <x-input id="billing_address_line2" name="billing_address_line2" type="text"
                                    class="mt-1 block w-full" :value="old('billing_address_line2', $team->billing_address_line2)" placeholder="Bâtiment B, Étage 3" />
                                <x-input-error for="billing_address_line2" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="billing_postal_code" value="{{ __('Code Postal') }}" />
                                <x-input id="billing_postal_code" name="billing_postal_code" type="text"
                                    class="mt-1 block w-full" :value="old('billing_postal_code', $team->billing_postal_code)" required placeholder="75000" />
                                <x-input-error for="billing_postal_code" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="billing_city" value="{{ __('Ville') }}" />
                                <x-input id="billing_city" name="billing_city" type="text" class="mt-1 block w-full"
                                    :value="old('billing_city', $team->billing_city)" required placeholder="Paris" />
                                <x-input-error for="billing_city" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-label for="billing_country" value="{{ __('Pays') }}" />
                                <select id="billing_country" name="billing_country"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 dark:focus:border-emerald-600 focus:ring-emerald-500 dark:focus:ring-emerald-600 rounded-md shadow-sm">
                                    <option value="FR" @selected(old('billing_country', $team->billing_country) === 'FR')>
                                        France</option>
                                    <option value="BE" @selected(old('billing_country', $team->billing_country) === 'BE')>
                                        Belgique</option>
                                    <option value="CH" @selected(old('billing_country', $team->billing_country) === 'CH')>
                                        Suisse</option>
                                    <option value="CA" @selected(old('billing_country', $team->billing_country) === 'CA')>
                                        Canada</option>
                                    <option value="LU" @selected(old('billing_country', $team->billing_country) === 'LU')>
                                        Luxembourg</option>
                                    <option value="XA" @selected(old('billing_country', $team->billing_country) === 'XA')>
                                        Autre</option>
                                </select>
                                <x-input-error for="billing_country" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-label for="vat_id" value="{{ __('Numéro de TVA (Optionnel)') }}" />
                            <x-input id="vat_id" name="vat_id" type="text" class="mt-1 block w-full"
                                :value="old('vat_id', $team->vat_id)" placeholder="FRXX123456789" />
                            <x-input-error for="vat_id" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-button>{{ __('Enregistrer') }}</x-button>

                            @if (session('status') === 'billing-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Enregistré.') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>

            {{-- FACTURES --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <section>
                    <header class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Factures') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Historique de vos factures téléchargeables.') }}
                            </p>
                        </div>
                    </header>

                    @if($invoices->isEmpty())
                        <div class="text-sm text-gray-500 dark:text-gray-400 italic">
                            {{ __('Aucune facture disponible pour le moment.') }}
                        </div>
                    @else
                        <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Date') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Montant') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Statut') }}
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">{{ __('Télécharger') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($invoices as $invoice)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $invoice->issued_at ? $invoice->issued_at->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ number_format($invoice->amount / 100, 2) }}
                                                {{ strtoupper($invoice->currency) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                @if($invoice->s3_path)
                                                    {{-- Note: En prod il faudrait une route sécurisée qui génère une URL signée,
                                                    mais si le bucket est public ou si on utilise Storage::url() ça peut aller pour
                                                    un MVP.
                                                    Idéalement: route download --}}
                                                    <a href="{{ Storage::disk('s3')->temporaryUrl($invoice->s3_path, now()->addMinutes(10)) }}"
                                                        target="_blank"
                                                        class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-600">
                                                        {{ __('Télécharger PDF') }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">{{ __('En cours...') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>
            </div>

            {{-- ZONE DE DANGER : DÉSABONNEMENT --}}
            @if (!$subscription->onGracePeriod() && $subscription->active())
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border-l-4 border-red-500">
                        <div class="max-w-xl">
                            <section>
                                <header>
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('Annuler l\'abonnement') }}
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('Arrêter le renouvellement automatique à la fin de la période.') }}
                                    </p>
                                </header>

                                <div class="mt-6">
                                    <button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-subscription-cancellation')"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        {{ __('Se désabonner') }}
                                    </button>
                                </div>

                                {{-- Custom Modal (No Livewire Dependency) --}}
                                <div x-data="{ show: false }"
                                    x-on:open-modal.window="if ($event.detail === 'confirm-subscription-cancellation') show = true"
                                    x-on:close.stop="show = false" x-on:keydown.escape.window="show = false" x-show="show"
                                    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: none;">

                                    <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false"
                                        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
                                    </div>

                                    <div x-show="show"
                                        class="mb-6 bg-white dark:bg-emerald-dark-600 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
                                        x-trap.inert.noscroll="show" x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave="ease-in duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                                        <form method="POST" action="{{ route('subscription.cancel', $team) }}" class="p-6">
                                            @csrf

                                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                {{ __('Êtes-vous sûr de vouloir vous désabonner ?') }}
                                            </h2>

                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                {{ __('Aidez-nous à nous améliorer. Pourquoi partez-vous ?') }}
                                            </p>

                                            <div class="mt-6 space-y-4">
                                                <label class="flex items-center">
                                                    <input type="radio" name="reason" value="too_expensive"
                                                        class="form-radio text-emerald-600 dark:bg-gray-700 dark:border-gray-600"
                                                        required>
                                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Trop cher</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="reason" value="missing_features"
                                                        class="form-radio text-emerald-600 dark:bg-gray-700 dark:border-gray-600">
                                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Fonctionnalités
                                                        manquantes</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="reason" value="bugs"
                                                        class="form-radio text-emerald-600 dark:bg-gray-700 dark:border-gray-600">
                                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Trop de
                                                        bugs</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="reason" value="other"
                                                        class="form-radio text-emerald-600 dark:bg-gray-700 dark:border-gray-600">
                                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Autre</span>
                                                </label>
                                            </div>

                                            <div class="mt-4">
                                                <label class="flex items-center">
                                                    <input type="checkbox" name="contact_allowed"
                                                        class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-emerald-600 shadow-sm focus:ring-emerald-500">
                                                    <span
                                                        class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Pouvons-nous vous recontacter pour en discuter ?') }}</span>
                                                </label>
                                            </div>

                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button type="button" x-on:click="show = false">
                                                    {{ __('Annuler') }}
                                                </x-secondary-button>

                                                <x-danger-button class="ml-3" type="submit">
                                                    {{ __('Confirmer le désabonnement') }}
                                                </x-danger-button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            @endif

    </div>
    </div>
</x-app-layout>