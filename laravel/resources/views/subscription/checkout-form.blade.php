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
                                :value="old('billing_name', $team->billing_name)" required autofocus />
                            <x-input-error for="billing_name" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="billing_address" value="{{ __('Adresse de facturation') }}" />
                            <x-input id="billing_address" name="billing_address" type="text" class="mt-1 block w-full"
                                :value="old('billing_address', $team->billing_address)" required
                                placeholder="123 Rue de la Paix, 75000 Paris" />
                            <x-input-error for="billing_address" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="vat_id" value="{{ __('Numéro de TVA (Optionnel)') }}" />
                            <x-input id="vat_id" name="vat_id" type="text" class="mt-1 block w-full"
                                :value="old('vat_id', $team->vat_id)" placeholder="FRXX123456789" />
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