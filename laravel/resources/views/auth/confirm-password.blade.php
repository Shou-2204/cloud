<x-guest-layout>
    <div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">

        {{-- NAVBAR --}}
        <nav class="flex-none w-full py-5 px-8 flex justify-between items-center z-20 transition-colors duration-300 bg-white dark:bg-slate-950 border-b border-gray-200 dark:border-slate-800 shadow-sm dark:shadow-xl">
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-tighter text-gray-900 dark:text-white">
                <span class="text-indigo-600 dark:text-indigo-500">Shou</span>Cloud
            </a>
            <div class="flex items-center space-x-6">
                <x-theme-switch />
            </div>
        </nav>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 relative overflow-hidden">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/10 dark:bg-indigo-600/10 blur-[100px] rounded-full -z-10 pointer-events-none"></div>

            <div class="w-full max-w-md space-y-8 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 z-10">
                
                <div class="text-center">
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Zone sécurisée
                    </h2>
                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-400 text-left">
                        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                    </p>
                </div>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('password.confirm') }}" class="mt-6">
                    @csrf

                    <div>
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" autofocus />
                    </div>

                    <div class="flex justify-end mt-6">
                        <x-button class="w-full flex justify-center py-3">
                            {{ __('Confirm') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-guest-layout>