<div class="w-full" x-data="{ 
    selectedIndex: 0,
    showResults: false,
    navigate() {
        let selectedEl = document.getElementById('search-result-' + this.selectedIndex);
        if (selectedEl) {
            window.location.href = selectedEl.href;
        }
    }
}">
    <div class="relative w-full text-left">
        {{-- Search Input --}}
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.200ms="query"
                @focus="showResults = true"
                @keydown.arrow-down.prevent="selectedIndex = (selectedIndex + 1) % {{ count($results) ?: 1 }}"
                @keydown.arrow-up.prevent="selectedIndex = (selectedIndex - 1 + {{ count($results) ?: 1 }}) % {{ count($results) ?: 1 }}"
                @keydown.enter.prevent="navigate()" 
                @keydown.escape="showResults = false"
                @input="selectedIndex = 0" 
                type="text"
                class="w-full pl-12 pr-4 py-2 bg-white dark:bg-emerald-dark-600 border border-gray-200 dark:border-emerald-dark-500 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:outline-none transition-all"
                style="padding-left: 3rem;"
                placeholder="Rechercher...">
        </div>

        {{-- Results Dropdown --}}
        @if(count($results) > 0)
            <div x-show="showResults" 
                 @click.away="showResults = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute z-50 mt-2 w-full min-w-[400px] bg-white dark:bg-emerald-dark-600 rounded-xl shadow-2xl border border-gray-200 dark:border-emerald-dark-500 overflow-hidden"
                 style="display: none;">
                <div class="py-1">
                    @foreach($results as $index => $page)
                        <a href="{{ $page->url }}" id="search-result-{{ $index }}"
                            :class="{ 'bg-emerald-50 dark:bg-emerald-900/40': selectedIndex === {{ $index }} }"
                            @mouseenter="selectedIndex = {{ $index }}"
                            @click="showResults = false"
                            class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-emerald-dark-500 transition-colors cursor-pointer">

                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/50 rounded-lg text-emerald-600 dark:text-emerald-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>

                            <div class="flex-1 min-w-0 text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ $page->title }}
                            </div>

                            <span class="text-[10px] font-mono text-gray-400 bg-gray-100 dark:bg-gray-700/50 px-1.5 py-0.5 rounded uppercase">
                                {{ $page->category }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>