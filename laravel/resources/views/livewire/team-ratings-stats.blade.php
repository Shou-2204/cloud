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

                    {{-- Main average display --}}
                    <div class="flex items-center gap-4">
                        <div
                            class="flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-500 shadow-lg">
                            <span class="text-4xl">⭐</span>
                        </div>
                        <div>
                            <div class="text-4xl font-extrabold text-gray-900 dark:text-white">
                                {{ $this->stats['average'] ?: '-' }}
                                <span class="text-lg font-normal text-gray-400">/5</span>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $this->stats['count'] }} avis
                                </span>
                                @if($this->stats['trend'] === 1)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        ↑ En hausse
                                    </span>
                                @elseif($this->stats['trend'] === -1)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                        ↓ En baisse
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Period selector --}}
                    <div class="flex bg-gray-100 dark:bg-emerald-dark-600 rounded-xl p-1">
                        <button wire:click="setPeriod('24h')"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $period === '24h' ? 'bg-white dark:bg-emerald-dark-500 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
                            24h
                        </button>
                        <button wire:click="setPeriod('7d')"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $period === '7d' ? 'bg-white dark:bg-emerald-dark-500 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
                            7 jours
                        </button>
                        <button wire:click="setPeriod('30d')"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $period === '30d' ? 'bg-white dark:bg-emerald-dark-500 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
                            30 jours
                        </button>
                    </div>
                </div>

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

{{-- Include Chart.js --}}
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
@endpush