<div>
    @if($team && $team->subscribed())
        <div class="mt-10" wire:key="ratings-stats-{{ $period }}">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span>📊</span> Statistiques des avis
            </h2>

            <div
                class="bg-white dark:bg-emerald-dark-500 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600">

                {{-- Header with average and period selector --}}
                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 pb-6 border-b border-gray-100 dark:border-emerald-dark-600">

                    {{-- Main average display with visual stars --}}
                    <div class="flex items-center gap-4">
                        {{-- Visual star rating --}}
                        @php
                            $avg = $this->stats['average'] ?: 0;
                            $roundedHalf = ceil($avg * 2) / 2; // Round to upper half
                        @endphp
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($roundedHalf))
                                    {{-- Full star --}}
                                    <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @elseif($i - 0.5 == $roundedHalf)
                                    {{-- Half star --}}
                                    <div class="relative w-8 h-8">
                                        <svg class="absolute w-8 h-8 text-gray-200 dark:text-gray-600" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <div class="absolute overflow-hidden w-4 h-8">
                                            <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    {{-- Empty star --}}
                                    <svg class="w-8 h-8 text-gray-200 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>

                        <div>
                            <div class="text-3xl font-extrabold text-gray-900 dark:text-white">
                                {{ $this->stats['average'] ?: '-' }}
                                <span class="text-base font-normal text-gray-400">/5</span>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $this->stats['count'] }} avis
                                </span>
                                @if($this->stats['trend'] === 1)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        ↑
                                    </span>
                                @elseif($this->stats['trend'] === -1)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                        ↓
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Button to get negative summary --}}
                        @if($this->stats['negative'] > 0)
                            <button wire:click="sendNegativeSummary" wire:loading.attr="disabled"
                                class="ml-4 px-3 py-2 text-xs font-medium rounded-lg bg-orange-100 text-orange-700 hover:bg-orange-200 dark:bg-orange-900/30 dark:text-orange-400 dark:hover:bg-orange-900/50 transition-colors">
                                <span wire:loading.remove wire:target="sendNegativeSummary">📧 Synthèse négatifs</span>
                                <span wire:loading wire:target="sendNegativeSummary">Envoi...</span>
                            </button>
                        @endif
                    </div>

                    {{-- Period selector with loading state --}}
                    <div class="flex bg-gray-100 dark:bg-emerald-dark-600 rounded-xl p-1 relative">
                        {{-- Loading overlay --}}
                        <div wire:loading wire:target="setPeriod"
                            class="absolute inset-0 bg-gray-100/80 dark:bg-emerald-dark-600/80 rounded-xl flex items-center justify-center z-10">
                            <svg class="animate-spin h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                        <button wire:click="setPeriod('24h')" wire:loading.class="opacity-50 cursor-wait"
                            wire:target="setPeriod"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $period === '24h' ? 'bg-white dark:bg-emerald-dark-500 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
                            24h
                        </button>
                        <button wire:click="setPeriod('7d')" wire:loading.class="opacity-50 cursor-wait"
                            wire:target="setPeriod"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $period === '7d' ? 'bg-white dark:bg-emerald-dark-500 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
                            7 jours
                        </button>
                        <button wire:click="setPeriod('30d')" wire:loading.class="opacity-50 cursor-wait"
                            wire:target="setPeriod"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $period === '30d' ? 'bg-white dark:bg-emerald-dark-500 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
                            30 jours
                        </button>
                    </div>
                </div>

                {{-- Flash message --}}
                @if(session('summary_sent'))
                    <div
                        class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 text-sm">
                        ✅ La synthèse des avis négatifs a été envoyée par email.
                    </div>
                @endif

                {{-- Stats cards --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                            {{ $this->stats['positive'] }}
                        </div>
                        <div class="text-sm text-emerald-700 dark:text-emerald-300">Avis positifs (4-5★)</div>
                    </div>
                    <div class="bg-orange-50 dark:bg-orange-900/20 rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $this->stats['negative'] }}
                        </div>
                        <div class="text-sm text-orange-700 dark:text-orange-300">Avis négatifs (1-3★)</div>
                    </div>
                </div>

                {{-- Chart --}}
                <div class="relative h-48" x-data="{
                                    chart: null,
                                    labels: @js($this->chartData['labels']),
                                    data: @js($this->chartData['data']),
                                    init() {
                                        this.renderChart();

                                        // Listen for Livewire updates
                                        Livewire.on('chart-updated', (params) => {
                                            this.labels = params[0].labels;
                                            this.data = params[0].data;
                                            this.renderChart();
                                        });
                                    },
                                    renderChart() {
                                        const ctx = this.$refs.canvas.getContext('2d');

                                        if (this.chart) {
                                            this.chart.destroy();
                                        }

                                        this.chart = new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: this.labels,
                                                datasets: [{
                                                    label: 'Note moyenne',
                                                    data: this.data,
                                                    borderColor: 'rgb(16, 185, 129)',
                                                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                                    fill: true,
                                                    tension: 0.4,
                                                    pointRadius: 4,
                                                    pointBackgroundColor: 'rgb(16, 185, 129)',
                                                    pointBorderColor: '#fff',
                                                    pointBorderWidth: 2,
                                                    spanGaps: true,
                                                }]
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: false,
                                                plugins: {
                                                    legend: { display: false },
                                                    tooltip: {
                                                        callbacks: {
                                                            label: (ctx) => ctx.parsed.y ? ctx.parsed.y + ' ⭐' : 'Aucun avis'
                                                        }
                                                    }
                                                },
                                                scales: {
                                                    y: {
                                                        min: 1,
                                                        max: 5,
                                                        ticks: { stepSize: 1 },
                                                        grid: { color: 'rgba(0,0,0,0.05)' }
                                                    },
                                                    x: {
                                                        grid: { display: false }
                                                    }
                                                }
                                            }
                                        });
                                    }
                                }" x-init="init()" wire:ignore>
                    <canvas x-ref="canvas"></canvas>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Include Chart.js --}}
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
@endpush