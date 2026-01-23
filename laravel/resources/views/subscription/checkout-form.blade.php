<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Finaliser votre abonnement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Informations de Facturation Manquantes') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Veuillez compléter vos informations de facturation pour procéder au paiement.') }}
                        </p>
                    </header>

                    <form method="POST" action="{{ route('subscription.store-checkout') }}" class="mt-6 space-y-6">
                        @csrf
                        <input type="hidden" name="price" value="{{ $price }}">

                        <div>
                            <x-label for="billing_name" value="{{ __('Nom de facturation / Entreprise') }}" />
                            <x-input id="billing_name" name="billing_name" type="text" class="mt-1 block w-full"
                                :value="old('billing_name', $team->billingDetail->billing_name)" required autofocus />
                            <x-input-error for="billing_name" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <x-label for="billing_address" value="{{ __('Adresse ligne 1') }}" />
                                <x-input id="billing_address" name="billing_address" type="text"
                                    class="mt-1 block w-full" :value="old('billing_address', $team->billingDetail->billing_address)"
                                    required placeholder="123 Rue de la Paix" />
                                <x-input-error for="billing_address" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-label for="billing_address_line2" value="{{ __('Adresse ligne 2 (Optionnel)') }}" />
                                <x-input id="billing_address_line2" name="billing_address_line2" type="text"
                                    class="mt-1 block w-full" :value="old('billing_address_line2', $team->billingDetail->billing_address_line2)" placeholder="Bâtiment B, Étage 3" />
                                <x-input-error for="billing_address_line2" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="billing_postal_code" value="{{ __('Code Postal') }}" />
                                <x-input id="billing_postal_code" name="billing_postal_code" type="text"
                                    class="mt-1 block w-full" :value="old('billing_postal_code', $team->billingDetail->billing_postal_code)" required placeholder="75000" />
                                <x-input-error for="billing_postal_code" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="billing_city" value="{{ __('Ville') }}" />
                                <x-input id="billing_city" name="billing_city" type="text" class="mt-1 block w-full"
                                    :value="old('billing_city', $team->billingDetail->billing_city)" required placeholder="Paris" />
                                <x-input-error for="billing_city" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-label for="billing_country" value="{{ __('Pays') }}" />
                                <select id="billing_country" name="billing_country"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="FR" @selected(old('billing_country', $team->billingDetail->billing_country) === 'FR')>
                                        France</option>
                                    <option value="BE" @selected(old('billing_country', $team->billingDetail->billing_country) === 'BE')>
                                        Belgique</option>
                                    <option value="CH" @selected(old('billing_country', $team->billingDetail->billing_country) === 'CH')>
                                        Suisse</option>
                                    <option value="CA" @selected(old('billing_country', $team->billingDetail->billing_country) === 'CA')>
                                        Canada</option>
                                    <option value="LU" @selected(old('billing_country', $team->billingDetail->billing_country) === 'LU')>
                                        Luxembourg</option>
                                    {{-- Add more as needed --}}
                                </select>
                                <x-input-error for="billing_country" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-label for="vat_id" value="{{ __('Numéro de TVA (Optionnel)') }}" />
                            <x-input id="vat_id" name="vat_id" type="text" class="mt-1 block w-full"
                                :value="old('vat_id', $team->billingDetail->vat_id)" placeholder="FRXX123456789" />
                            <x-input-error for="vat_id" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-8">
                            <a href="{{ route('subscription.index') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline">
                                {{ __('Annuler') }}
                            </a>

                            <x-button class="bg-indigo-600 hover:bg-indigo-500">
                                {{ __('Continuer vers le Paiement') }} &rarr;
                            </x-button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>