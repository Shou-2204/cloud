<div class="relative" wire:poll.30s x-data="{ open: false }">
    {{-- Bell Icon --}}
    <button @click="open = !open"
            @click.away="open = false"
            class="relative p-1 text-emerald-100 hover:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 rounded-full"
            title="Notifications">

        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
            </path>
        </svg>

        @if($this->unreadCount > 0)
            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full ring-2 ring-emerald-600">
                {{ $this->unreadCount > 99 ? '99+' : $this->unreadCount }}
            </span>
        @endif
    </button>

    {{-- Dropdown Menu --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white dark:bg-emerald-dark-700 rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 py-1 z-50 overflow-hidden"
         style="display: none;">

        <div class="px-4 py-2 border-b border-gray-100 dark:border-emerald-dark-600 bg-gray-50 dark:bg-emerald-dark-800/50">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
        </div>

        <div class="max-h-96 overflow-y-auto">
            @forelse($this->notifications as $notification)
                <div class="group relative px-4 py-3 hover:bg-gray-50 dark:hover:bg-emerald-dark-600 transition-colors border-b border-gray-50 dark:border-emerald-dark-600 last:border-0">
                    <a href="{{ $notification->data['url'] ?? '#' }}"
                       @click="open = false"
                       class="flex items-start">
                        <div class="flex-shrink-0 pt-0.5">
                            {{-- Generic Icon or Specific based on type --}}
                            <div class="h-8 w-8 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $notification->data['message'] ?? 'Nouvelle notification' }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </a>

                    {{-- Dismiss Button --}}
                    <button wire:click.stop="markAsRead('{{ $notification->id }}')"
                            class="absolute top-2 right-2 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-full hover:bg-gray-100 dark:hover:bg-emerald-dark-500 transition-colors opacity-0 group-hover:opacity-100 focus:opacity-100"
                            title="Marquer comme lu">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @empty
                <div class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                    Aucune nouvelle notification
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        @if($this->unreadCount > 0)
            <div class="border-t border-gray-100 dark:border-emerald-dark-600 bg-gray-50 dark:bg-emerald-dark-800/50">
                <button wire:click="markAllAsRead"
                        class="block w-full px-4 py-2 text-center text-xs font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                    Tout marquer comme lu
                </button>
            </div>
        @endif
    </div>
</div>
