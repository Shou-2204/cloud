{{-- File: resources/views/auth/login.blade.php --}}
<x-guest-layout>
    {{-- Conteneur principal flexible --}}
    <div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">

        {{-- 1. LA BARRE DE NAVIGATION --}}
    <nav class="flex-none w-full py-5 px-8 flex justify-between items-center z-20 transition-colors duration-300 bg-white dark:bg-slate-950 border-b border-gray-200 dark:border-slate-800 shadow-sm dark:shadow-xl">
        {{-- Logo : Texte noir en mode clair, blanc en mode sombre --}}
        <a href="{{ url('/') }}" class="text-xl font-bold tracking-tighter text-gray-900 dark:text-white">
            <span class="text-indigo-600 dark:text-indigo-500">Shou</span>Cloud
        </a>

        <div class="flex items-center space-x-6">
            {{-- Switch Theme --}}
            <x-theme-switch />
        </div>
    </nav>

        {{-- 2. CONTENU PRINCIPAL CENTRÉ --}}
        <main class="flex-1 flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 relative overflow-hidden">
            {{-- Fond décoratif --}}
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/10 dark:bg-indigo-600/10 blur-[100px] rounded-full -z-10 pointer-events-none"></div>

            {{-- Carte Formulaire --}}
            <div class="w-full max-w-md space-y-8 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 z-10">

                <div class="text-center">
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Connexion à votre espace
                    </h2>
                </div>

                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-xs font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300" href="{{ route('password.request') }}">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    {{-- MODIFICATION ICI : Grille de 2 boutons --}}
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        {{-- Bouton Connexion (Primaire / Sombre) --}}
                        <x-button class="w-full flex justify-center py-3">
                            {{ __('Log in') }}
                        </x-button>

                        {{-- Bouton Inscription (Secondaire / Outline) --}}
                        <a href="{{ route('register') }}" class="w-full flex justify-center items-center py-3 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            S'inscrire
                        </a>
                    </div>

                    {{-- Divider --}}
                    <div class="relative mt-8">
                        <div class="absolute inset-0 flex items-center">
                            <span class="w-full border-t border-gray-300 dark:border-gray-700"></span>
                        </div>
                        <div class="relative flex justify-center text-xs uppercase">
                            <span class="bg-white dark:bg-gray-800 px-2 text-gray-500 dark:text-gray-400">
                                Ou continuer avec
                            </span>
                        </div>
                    </div>

                    {{-- Bouton Google --}}
                    <div class="mt-6">
                        <a href="{{ route('auth.google') }}" class="flex w-full items-center justify-center gap-3 rounded-md bg-white dark:bg-slate-800 px-3 py-3 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 focus-visible:ring-transparent transition-all duration-200">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                            </svg>
                            <span class="text-sm font-medium">Google</span>
                        </a>
                    </div>

                </form>
            </div>
        </main>
    </div>
</x-guest-layout>