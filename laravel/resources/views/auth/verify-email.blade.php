<x-guest-layout>
    <div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">

        {{-- NAVBAR --}}
        <nav class="flex-none w-full py-5 px-8 flex justify-between items-center z-20 transition-colors duration-300 bg-white dark:bg-slate-950 border-b border-gray-200 dark:border-slate-800 shadow-sm dark:shadow-xl">
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-tighter text-gray-900 dark:text-white">
                <span class="text-indigo-600 dark:text-indigo-500">Shou</span>Cloud
            </a>
            <div class="flex items-center space-x-6">
                <x-theme-switch />
                {{-- Bouton de déconnexion dans la navbar pour sortir si besoin --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition">
                        Déconnexion
                    </button>
                </form>
            </div>
        </nav>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 relative overflow-hidden">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/10 dark:bg-indigo-600/10 blur-[100px] rounded-full -z-10 pointer-events-none"></div>

            <div class="w-full max-w-md space-y-8 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 z-10">
                
                <div class="text-center">
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Vérifiez votre email
                    </h2>
                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-400 text-left leading-relaxed">
                        {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                        {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                    </div>
                @endif

                <div class="mt-6 flex flex-col gap-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <x-button type="submit" class="w-full flex justify-center py-3">
                            {{ __('Resend Verification Email') }}
                        </x-button>
                    </form>

                    <div class="flex justify-between items-center mt-2">
                        <a href="{{ route('profile.show') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                            {{ __('Edit Profile') }}
                        </a>
                        
                        {{-- Déconnexion alternative en bas --}}
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-guest-layout>