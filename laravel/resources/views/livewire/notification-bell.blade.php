<div class="relative" x-data="{ open: false }">
    <style>
        @keyframes swing {
            0% { transform: rotate(0deg); }
            15% { transform: rotate(15deg); }
            30% { transform: rotate(-10deg); }
            45% { transform: rotate(5deg); }
            60% { transform: rotate(-5deg); }
            75% { transform: rotate(2deg); }
            100% { transform: rotate(0deg); }
        }
        .animate-swing {
            animation: swing 1.5s ease-in-out infinite;
        }
    </style>
    {{-- Bell Icon --}}
    {{-- Bell Icon --}}
    <button @click="open = !open"
            @click.away="open = false"
            class="relative p-1 @if($this->unreadCount > 0) text-yellow-400 hover:text-yellow-300 @else text-white hover:text-emerald-100 @endif transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 rounded-full"
            title="Notifications">

        <svg class="w-6 h-6 transform origin-top @if($this->unreadCount > 0) animate-swing @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
            </path>
        </svg>

        {{-- Petit point rouge discret si notifications --}}
        @if($this->unreadCount > 0)
            <span class="absolute top-1.5 right-1.5 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-emerald-600"></span>
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
         class="absolute right-0 mt-2 w-[28rem] bg-white dark:bg-emerald-dark-700 rounded-xl shadow-xl ring-1 ring-black/5 z-50 overflow-hidden"
         style="display: none;">

        {{-- Header --}}
        <div class="px-4 py-2 border-b border-gray-100 dark:border-emerald-dark-600 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
            @if($this->unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs text-emerald-600 dark:text-emerald-400 hover:underline">
                    Tout lire
                </button>
            @endif
        </div>

        {{-- Notifications List --}}
        <div class="max-h-64 overflow-y-auto">
            @forelse($this->notifications->take(5) as $notification)
                <div class="group relative flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-emerald-dark-600 transition-colors border-b border-gray-50 dark:border-emerald-dark-600 last:border-0">
                    @php
                        $data = $notification->data;
                        $url = $data['url'] ?? '#';
                        $message = $data['message'] ?? 'Nouvelle notification';
                        $icon = 'bell'; // Default icon
                        $iconColor = 'text-gray-400 group-hover:text-emerald-500';

                        // Legacy support for TeamActivityLog
                        if ($url === '#' && isset($data['team_id'])) {
                            try {
                                $url = route('teams.show', $data['team_id']);
                            } catch (\Exception $e) {}
                        }
                        
                        // Force translation & Icons if action is known
                        if (isset($data['action'])) {
                            $actions = [
                                'team_updated' => ['label' => 'Mise à jour de l\'équipe', 'icon' => 'pencil'],
                                'team_renamed' => ['label' => 'Organisation renommée', 'icon' => 'tag'],
                                'settings_updated' => ['label' => 'Paramètres modifiés', 'icon' => 'cog'],
                                'organization_renamed' => ['label' => 'Organisation renommée', 'icon' => 'tag'],
                                'member_added' => ['label' => 'Nouveau collaborateur', 'icon' => 'user-add'],
                                'member_removed' => ['label' => 'Collaborateur retiré', 'icon' => 'user-remove'],
                                'review_received' => ['label' => 'Nouvel avis reçu', 'icon' => 'star'],
                            ];
                            
                            if (isset($actions[$data['action']])) {
                                $message = 'Activité : ' . $actions[$data['action']]['label'];
                                $icon = $actions[$data['action']]['icon'];
                            } elseif ($message === 'Nouvelle notification') {
                                // Fallback
                                $message = 'Activité : ' . ucfirst(str_replace('_', ' ', $data['action']));
                            }
                        }
                        
                        // Icon mapping
                        $svgIcon = match($icon) {
                            'pencil' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />',
                            'tag' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />',
                            'cog' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />',
                            'user-add' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />',
                            'user-remove' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />',
                            'star' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />',
                            default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />'
                        };
                    @endphp
                    <a href="{{ route('notifications.read', $notification->id) }}"
                       @click="open = false"
                       class="flex-1 min-w-0 flex items-center gap-3">
                        
                        {{-- Icon --}}
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 {{ $icon === 'star' ? 'text-yellow-400' : 'text-gray-400 dark:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                {!! $svgIcon !!}
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0">
                            {{-- Message --}}
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                {{ $message }}
                            </p>
                            {{-- Time --}}
                            <p class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">
                                {{ $notification->created_at->diffForHumans(short: true) }}
                            </p>
                        </div>
                    </a>
                    {{-- Dismiss --}}
                    <button wire:click.stop="markAsRead('{{ $notification->id }}')"
                            class="p-1 text-gray-300 hover:text-red-500 dark:text-gray-600 dark:hover:text-red-400 rounded transition-colors opacity-0 group-hover:opacity-100"
                            title="Marquer comme lu">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @empty
                <div class="px-4 py-4 flex items-center justify-center gap-2 text-sm text-gray-400 dark:text-gray-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span>Aucune notification</span>
                </div>
            @endforelse
        </div>
    </div>
</div>
