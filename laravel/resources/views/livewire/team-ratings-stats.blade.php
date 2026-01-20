<div>
    @if($team && $team->subscribed())
        <div class="mt-10">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span>📊</span> Statistiques des avis
            </h2>

            <div
                class="bg-white dark:bg-emerald-dark-500 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600">

                {{-- Overall average --}}
                <div
                    class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100 dark:border-emerald-dark-600">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Note moyenne globale</div>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $this->totalAverage }}</span>
                        <span class="text-yellow-400">⭐</span>
                    </div>
                </div>

                {{-- Stats table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 dark:text-gray-400">
                                <th class="pb-3 font-medium">Période</th>
                                <th class="pb-3 font-medium text-center">Avis</th>
                                <th class="pb-3 font-medium text-center">Moyenne</th>
                                <th class="pb-3 font-medium text-center">Tendance</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900 dark:text-white">
                            {{-- 24h --}}
                            <tr class="border-t border-gray-50 dark:border-emerald-dark-600">
                                <td class="py-3 font-medium">24 heures</td>
                                <td class="py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center min-w-[2rem] px-2 py-1 rounded-full text-xs font-bold {{ $this->stats24h['count'] > 0 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                                        {{ $this->stats24h['count'] }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    @if($this->stats24h['count'] > 0)
                                        {{ $this->stats24h['average'] }} ⭐
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    @if($this->stats24h['trend'] === 1)
                                        <span class="text-emerald-500">↑</span>
                                    @elseif($this->stats24h['trend'] === -1)
                                        <span class="text-red-500">↓</span>
                                    @else
                                        <span class="text-gray-400">→</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- 7 days --}}
                            <tr class="border-t border-gray-50 dark:border-emerald-dark-600">
                                <td class="py-3 font-medium">7 jours</td>
                                <td class="py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center min-w-[2rem] px-2 py-1 rounded-full text-xs font-bold {{ $this->stats7d['count'] > 0 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                                        {{ $this->stats7d['count'] }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    @if($this->stats7d['count'] > 0)
                                        {{ $this->stats7d['average'] }} ⭐
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    @if($this->stats7d['trend'] === 1)
                                        <span class="text-emerald-500">↑</span>
                                    @elseif($this->stats7d['trend'] === -1)
                                        <span class="text-red-500">↓</span>
                                    @else
                                        <span class="text-gray-400">→</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- 30 days --}}
                            <tr class="border-t border-gray-50 dark:border-emerald-dark-600">
                                <td class="py-3 font-medium">30 jours</td>
                                <td class="py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center min-w-[2rem] px-2 py-1 rounded-full text-xs font-bold {{ $this->stats30d['count'] > 0 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                                        {{ $this->stats30d['count'] }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    @if($this->stats30d['count'] > 0)
                                        {{ $this->stats30d['average'] }} ⭐
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    @if($this->stats30d['trend'] === 1)
                                        <span class="text-emerald-500">↑</span>
                                    @elseif($this->stats30d['trend'] === -1)
                                        <span class="text-red-500">↓</span>
                                    @else
                                        <span class="text-gray-400">→</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Link to review page --}}
                @if($team->public_uuid)
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-emerald-dark-600 text-center">
                        <a href="{{ route('profile.review', $team) }}" target="_blank"
                            class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-medium">
                            Voir la page d'avis →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>