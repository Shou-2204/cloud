{{-- File: resources/views/auth/forgot-password.blade.php --}}
<x-guest-layout>
    <div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">

        {{-- 1. NAVBAR --}}
        <nav class="flex-none w-full py-5 px-8 flex justify-between items-center z-20 transition-colors duration-300 bg-white dark:bg-slate-950 border-b border-gray-200 dark:border-slate-800 shadow-sm dark:shadow-xl">
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-tighter text-gray-900 dark:text-white">
                <span class="text-indigo-600 dark:text-indigo-500">Shou</span>Cloud
            </a>

            <div class="flex items-center space-x-6">
                <x-theme-switch />
            </div>
        </nav>

        {{-- 2. CONTENU PRINCIPAL --}}
        <main class="flex-1 flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 relative overflow-hidden">
            {{-- Fond décoratif --}}
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/10 dark:bg-indigo-600/10 blur-[100px] rounded-full -z-10 pointer-events-none"></div>

            {{-- Carte --}}
            <div class="w-full max-w-md space-y-8 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 z-10">
                
                <div class="text-center">
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Récupération
                    </h2>
                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-400 text-left leading-relaxed">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </p>
                </div>

                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    {{-- Actions : Bouton d'envoi + Bouton Annuler --}}
                    <div class="flex flex-col gap-3 mt-6">
                        {{-- Bouton Principal --}}
                        <x-button class="w-full flex justify-center py-3 text-center">
                            {{ __('Email Password Reset Link') }}
                        </x-button>

                        {{-- AJOUT ICI : Bouton Annuler / Retour --}}
                        <a href="{{ route('login') }}" class="w-full flex justify-center items-center py-3 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none transition duration-150 ease-in-out">
                            Retour à la connexion
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-guest-layout>