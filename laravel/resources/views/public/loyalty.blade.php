<x-public-layout removeFooter="true" :seo="['title' => 'Programme de Fidélité - ' . $team->name, 'description' => 'Rejoindre le programme de fidélité VIP de ' . $team->name]">
    <div class="min-h-screen font-sans flex text-gray-900 overflow-x-hidden relative">

        <!-- Background Elements for smaller screens -->
        <div class="absolute inset-0 bg-gray-50 dark:bg-gray-900 z-0 lg:hidden"></div>
        @if(!$team->profile->cover_image_path)
             <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 via-teal-500/20 to-blue-500/20 z-0 lg:hidden blur-3xl"></div>
        @endif

        <!-- LEFT SIDE: Visual & Brand identity -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 items-center justify-center overflow-hidden">
            @if($team->profile->cover_image_path)
                <!-- Cover Image Background -->
                <div class="absolute inset-0 w-full h-full">
                    <img src="{{ Storage::disk('cloud_public')->url($team->profile->cover_image_path) }}" alt="{{ $team->name }} Cover" class="w-full h-full object-cover opacity-60">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent mix-blend-multiply"></div>
                    <div class="absolute inset-0 bg-emerald-900/20 mix-blend-overlay"></div>
                </div>
            @else
                <!-- Dynamic Gradient Background -->
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-800 via-teal-900 to-gray-900">
                    <div class="absolute inset-0 opacity-30 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-overlay"></div>
                </div>
            @endif

            <!-- Glassmorphism Brand Card -->
            <div class="relative z-10 w-full max-w-lg p-10 mx-auto rounded-3xl bg-white/10 dark:bg-black/20 backdrop-blur-md border border-white/20 shadow-2xl text-center transform hover:scale-[1.02] transition-transform duration-500">
                @if($team->profile->logo_path)
                    <img class="mx-auto h-28 w-28 rounded-2xl ring-4 ring-white/30 object-cover shadow-lg bg-white"
                         src="{{ Storage::disk('cloud_public')->url($team->profile->logo_path) }}" alt="{{ $team->name }}">
                @else
                    <div class="mx-auto h-28 w-28 rounded-2xl ring-4 ring-white/30 bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center text-5xl font-extrabold text-white shadow-lg">
                        {{ substr($team->name, 0, 1) }}
                    </div>
                @endif
                
                <h1 class="mt-8 text-4xl font-extrabold text-white tracking-tight drop-shadow-md">
                    {{ $team->name }}
                </h1>
                
                @if($team->profile->tagline)
                    <p class="mt-4 text-xl text-emerald-100 font-medium drop-shadow">
                        {{ $team->profile->tagline }}
                    </p>
                @endif

                <div class="mt-8 w-16 h-1 bg-gradient-to-r from-emerald-400 to-teal-500 mx-auto rounded-full"></div>

                <div class="mt-8 text-emerald-50 max-w-sm mx-auto space-y-3 font-medium">
                    <p class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Cumulez des points à chaque passage
                    </p>
                    <p class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                        Débloquez des récompenses exclusives
                    </p>
                    <p class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        Recevez des offres VIP personnalisées
                    </p>
                </div>
            </div>
            
            <!-- Floating particles / decor -->
            <div class="absolute top-1/4 left-10 w-24 h-24 bg-teal-500/20 rounded-full blur-2xl animate-pulse"></div>
            <div class="absolute bottom-1/4 right-10 w-32 h-32 bg-emerald-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <!-- RIGHT SIDE: The Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center relative z-10 px-4 sm:px-6 lg:px-20 xl:px-24 py-8 lg:py-12 min-h-screen lg:min-h-0 lg:h-screen overflow-y-auto">
            
            <!-- Mobile Brand Header (only visible on small screens) -->
            <div class="lg:hidden text-center mt-8 mb-6 relative">
                 @if($team->profile->logo_path)
                    <img class="mx-auto h-20 w-20 rounded-xl ring-2 ring-emerald-500/30 object-cover shadow-sm bg-white"
                         src="{{ Storage::disk('cloud_public')->url($team->profile->logo_path) }}" alt="{{ $team->name }}">
                @else
                    <div class="mx-auto h-20 w-20 rounded-xl ring-2 ring-emerald-500/30 bg-gradient-to-br from-emerald-100 to-teal-50 dark:from-emerald-900/50 dark:to-teal-900/50 flex items-center justify-center text-3xl font-bold text-emerald-600 dark:text-emerald-400 shadow-sm">
                        {{ substr($team->name, 0, 1) }}
                    </div>
                @endif
                <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">{{ $team->name }}</h2>
            </div>
            
            <!-- Navigation Back -->
            <div class="hidden lg:flex justify-end lg:absolute lg:top-8 lg:right-10 mb-4 lg:mb-0 pt-4 lg:pt-0">
                <a href="{{ route('profile.public', $team->public_uuid) }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 bg-white dark:bg-gray-800 px-4 py-2 rounded-full shadow-sm border border-gray-100 dark:border-gray-700 transition hover:shadow-md group">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Retour au profil
                </a>
            </div>

            <div class="mt-12 lg:mt-0 max-w-md w-full mx-auto">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg py-8 px-6 shadow-2xl sm:rounded-3xl sm:px-10 border border-white/50 dark:border-gray-700/50 relative overflow-hidden">
                    <!-- Subtle glow behind form -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-100 dark:bg-emerald-900/30 rounded-full blur-3xl opacity-50 z-0"></div>
                    
                    <div class="relative z-10">
                        <livewire:join-loyalty-program :team="$team" />
                    </div>
                </div>
                
                <p class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500">
                    Vos données sont sécurisées et destinées uniquement à <strong>{{ $team->name }}</strong>.<br>
                    Propulsé par <a href="{{ config('app.url') }}" target="_blank" class="text-emerald-500 hover:text-emerald-600">InZeeCard</a>
                </p>
            </div>
        </div>

    </div>
</x-public-layout>
