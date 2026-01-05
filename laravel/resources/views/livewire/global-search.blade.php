<div class="w-full px-4 sm:px-0">
    <div x-data="{ 
        selectedIndex: 0,
        navigate() {
            let selectedEl = document.getElementById('search-result-' + this.selectedIndex);
            if (selectedEl) {
                window.location.href = selectedEl.href;
            }
        }
    }" class="relative w-full max-w-2xl mx-auto text-left">

        {{-- Barre de recherche --}}
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-indigo-500">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input 
                wire:model.live.debounce.200ms="query" 
                @keydown.arrow-down.prevent="selectedIndex = (selectedIndex + 1) % {{ count($results) ?: 1 }}"
                @keydown.arrow-up.prevent="selectedIndex = (selectedIndex - 1 + {{ count($results) ?: 1 }}) % {{ count($results) ?: 1 }}"
                @keydown.enter.prevent="navigate()"
                @input="selectedIndex = 0"
                type="text" 
                class="block w-full pl-11 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 transition-all"
                placeholder="Rechercher (Dashboard, Factures...)"
                autofocus
            >
        </div>

        {{-- Liste des résultats --}}
        @if(count($results) > 0)
            <div class="absolute z-50 mt-2 w-full bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-1">
                    @foreach($results as $index => $page)
                        {{-- ATTENTION : Ici on utilise la syntaxe objet -> au lieu de tableau [] --}}
                        <a href="{{ $page->url }}" 
                           id="search-result-{{ $index }}"
                           :class="{ 'bg-indigo-50 dark:bg-indigo-900/30 ring-1 ring-indigo-500': selectedIndex === {{ $index }} }"
                           @mouseenter="selectedIndex = {{ $index }}"
                           class="flex items-center px-3 py-2 rounded-xl transition-all duration-200 group no-underline cursor-pointer">
                           
                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/40 rounded-lg text-indigo-600 dark:text-indigo-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>

                            <div class="ml-3 flex-1 min-w-0 text-sm font-bold text-gray-900 dark:text-white truncate">
                                {{ $page->title }}
                            </div>

                            <div class="ml-auto text-[10px] font-mono text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-1.5 py-0.5 rounded border border-gray-200 dark:border-gray-600 uppercase">
                                {{ $page->category }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>