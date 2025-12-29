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

            <div class="w-full max-w-md space-y-8 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 z-10" x-data="{ recovery: false }">
                
                <div class="text-center">
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Double Authentification
                    </h2>
                    
                    <div class="mt-4 text-sm text-gray-600 dark:text-gray-400 text-left" x-show="! recovery">
                        {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                    </div>

                    <div class="mt-4 text-sm text-gray-600 dark:text-gray-400 text-left" x-cloak x-show="recovery">
                        {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                    </div>
                </div>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('two-factor.login') }}" class="mt-6">
                    @csrf

                    <div class="mt-4" x-show="! recovery">
                        <x-label for="code" value="{{ __('Code') }}" />
                        <x-input id="code" class="block mt-1 w-full text-center text-lg tracking-widest" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" placeholder="XXXXXX" />
                    </div>

                    <div class="mt-4" x-cloak x-show="recovery">
                        <x-label for="recovery_code" value="{{ __('Recovery Code') }}" />
                        <x-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="button" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 underline cursor-pointer"
                                x-show="! recovery"
                                x-on:click="
                                    recovery = true;
                                    $nextTick(() => { $refs.recovery_code.focus() })
                                ">
                            {{ __('Use a recovery code') }}
                        </button>

                        <button type="button" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 underline cursor-pointer"
                                x-cloak
                                x-show="recovery"
                                x-on:click="
                                    recovery = false;
                                    $nextTick(() => { $refs.code.focus() })
                                ">
                            {{ __('Use an authentication code') }}
                        </button>

                        <x-button class="ms-4">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-guest-layout>