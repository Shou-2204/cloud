<x-guest-layout>
    <div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">

        {{-- 1. NAVBAR (Avec lien vers Connexion) --}}
        <nav
            class="flex-none w-full py-5 px-8 flex justify-between items-center z-20 transition-colors duration-300 bg-white dark:bg-slate-950 border-b border-gray-200 dark:border-slate-800 shadow-sm dark:shadow-xl">
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-tighter text-gray-900 dark:text-white">
                <span class="text-indigo-600 dark:text-indigo-500">Shou</span>Cloud
            </a>

            <div class="flex items-center space-x-6">
                <x-theme-switch />
                <a href="{{ route('login') }}"
                    class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    Se connecter
                </a>
            </div>
        </nav>

        {{-- 2. CONTENU PRINCIPAL --}}
        <main class="flex-1 flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 relative overflow-hidden">
            {{-- Fond décoratif --}}
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/10 dark:bg-indigo-600/10 blur-[100px] rounded-full -z-10 pointer-events-none">
            </div>

            {{-- Carte --}}
            <div
                class="w-full max-w-md space-y-8 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 z-10">

                <div class="text-center">
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Créer un compte
                    </h2>
                </div>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                    @csrf

                    <div>
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                            required autofocus autocomplete="name" />
                    </div>

                    <div class="mt-4">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                            required autocomplete="username" />
                    </div>

                    <div x-data="{
                        password: '',
                        password_confirmation: '',
                        policy: {{ json_encode($passwordPolicy) }},
                        get criteria() {
                            return {
                                length: this.password.length >= this.policy.min,
                                mixed: !this.policy.mixedCase || (/[a-z]/.test(this.password) && /[A-Z]/.test(this.password)),
                                number: !this.policy.numbers || /[0-9]/.test(this.password),
                                symbol: !this.policy.symbols || /[^\w\s]/.test(this.password),
                                match: this.password.length > 0 && this.password === this.password_confirmation
                            }
                        }
                    }">
                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Password') }}" />
                            <x-input-password id="password" name="password" required autocomplete="new-password"
                                x-model="password" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                            <x-input-password id="password_confirmation" name="password_confirmation" required
                                autocomplete="new-password" x-model="password_confirmation" />
                        </div>

                        {{-- Password Validation Checklist --}}
                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-sm" x-show="password.length > 0" x-transition x-cloak>
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Critères du mot de passe :</h4>
                            <ul class="space-y-1">
                                <li class="flex items-center gap-2" :class="criteria.length ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'">
                                    <svg x-show="criteria.length" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <svg x-show="!criteria.length" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    <span x-text="'Au moins ' + policy.min + ' caractères'"></span>
                                </li>
                                <li x-show="policy.mixedCase" class="flex items-center gap-2" :class="criteria.mixed ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'">
                                    <svg x-show="criteria.mixed" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <svg x-show="!criteria.mixed" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Majuscule & Minuscule
                                </li>
                                <li x-show="policy.numbers" class="flex items-center gap-2" :class="criteria.number ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'">
                                    <svg x-show="criteria.number" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <svg x-show="!criteria.number" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Au moins un chiffre
                                </li>
                                <li x-show="policy.symbols" class="flex items-center gap-2" :class="criteria.symbol ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'">
                                    <svg x-show="criteria.symbol" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <svg x-show="!criteria.symbol" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Au moins un symbole
                                </li>
                                <li class="flex items-center gap-2" :class="criteria.match ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'">
                                    <svg x-show="criteria.match" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <svg x-show="!criteria.match" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Les mots de passe correspondent
                                </li>
                            </ul>
                        </div>
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                        <div class="mt-4">
                                            <x-label for="terms">
                                                <div class="flex items-center">
                                                    <x-checkbox name="terms" id="terms" required />
                                                    <div class="ms-2">
                                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' . __('Terms of Service') . '</a>',
                            'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' . __('Privacy Policy') . '</a>',
                        ]) !!}
                                                    </div>
                                                </div>
                                            </x-label>
                                        </div>
                    @endif

                    <div class="mt-6">
                        <x-button class="w-full flex justify-center py-3">
                            {{ __('Register') }}
                        </x-button>
                    </div>

                    {{-- Divider --}}
                    <div class="relative mt-8">
                        <div class="absolute inset-0 flex items-center">
                            <span class="w-full border-t border-gray-300 dark:border-gray-700"></span>
                        </div>
                        <div class="relative flex justify-center text-xs uppercase">
                            <span class="bg-white dark:bg-gray-800 px-2 text-gray-500 dark:text-gray-400">
                                Ou s'inscrire avec
                            </span>
                        </div>
                    </div>

                    {{-- Bouton Google --}}
                    <div class="mt-6">
                        <a href="{{ route('auth.google') }}"
                            class="flex w-full items-center justify-center gap-3 rounded-md bg-white dark:bg-slate-800 px-3 py-3 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 focus-visible:ring-transparent transition-all duration-200">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                            <span class="text-sm font-medium">Google</span>
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-guest-layout>