<div>
    @if($team && $team->subscribed())
        <div class="mt-10" wire:key="ratings-stats-{{ $period }}">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span>📊</span> Statistiques des avis
            </h2>

            <div
                class="bg-white dark:bg-emerald-dark-500 rounded-3xl p-4 sm:p-6 shadow-sm border border-gray-100 dark:border-emerald-dark-600">

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
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @elseif($i - 0.5 == $roundedHalf)
                                    {{-- Half star --}}
                                    <div class="relative w-6 h-6 sm:w-8 sm:h-8">
                                        <svg class="absolute w-6 h-6 sm:w-8 sm:h-8 text-gray-200 dark:text-gray-600"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <div class="absolute overflow-hidden w-3 h-6 sm:w-4 sm:h-8">
                                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-yellow-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    {{-- Empty star --}}
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-200 dark:text-gray-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>

                        <div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white">
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

                    {{-- Period selector --}}
                    <div class="flex bg-gray-100 dark:bg-emerald-dark-600 rounded-xl p-1 relative isolate"
                        x-data="{ activePeriod: '{{ $period }}' }" wire:ignore>
                        {{-- Sliding Pill --}}
                        <div class="absolute top-1 bottom-1 bg-white dark:bg-emerald-dark-500 rounded-lg shadow-sm transition-all duration-300 ease-out -z-10"
                            :class="{
                                                'left-1 w-[calc(33.33%-0.33rem)]': activePeriod === '24h',
                                                'left-[calc(33.33%+0.33rem)] w-[calc(33.33%-0.66rem)]': activePeriod === '7d',
                                                'left-[calc(66.66%+0.33rem)] w-[calc(33.33%-0.5rem)]': activePeriod === '30d'
                                            }"></div>

                        {{-- Buttons --}}
                        <button wire:click="setPeriod('24h')" @click="activePeriod = '24h'"
                            class="flex-1 px-2 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-lg transition-colors relative z-10"
                            :class="activePeriod === '24h' ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200'">
                            24h
                        </button>
                        <button wire:click="setPeriod('7d')" @click="activePeriod = '7d'"
                            class="flex-1 px-2 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-lg transition-colors relative z-10"
                            :class="activePeriod === '7d' ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200'">
                            <span class="hidden sm:inline">7 jours</span>
                            <span class="sm:hidden">7j</span>
                        </button>
                        <button wire:click="setPeriod('30d')" @click="activePeriod = '30d'"
                            class="flex-1 px-2 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-lg transition-colors relative z-10"
                            :class="activePeriod === '30d' ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200'">
                            <span class="hidden sm:inline">30 jours</span>
                            <span class="sm:hidden">30j</span>
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
                <div class="relative h-40 sm:h-48" x-data="{
                                                    chart: null,
                                                    labels: @js($this->chartData['labels']),
                                                    data: @js($this->chartData['data']),
                                                    init() {
                                                        this.renderChart();

                                                        // Listen for Livewire updates
                                                        Livewire.on('chart-updated', (params) => {
                                                            this.labels = params[0].labels;
                                                            this.data = params[0].data;
                                                            this.updateChart();
                                                        });
                                                    },
                                                    updateChart() {
                                                        if (this.chart) {
                                                            this.chart.updateSeries([{
                                                                name: 'Note moyenne',
                                                                data: this.data
                                                            }]);
                                                            this.chart.updateOptions({
                                                                xaxis: {
                                                                    categories: this.labels
                                                                }
                                                            });
                                                        }
                                                    },
                                                    renderChart() {
                                                        if (this.chart) {
                                                            this.chart.destroy();
                                                        }

                                                    const options = {
                                                        series: [{
                                                            name: 'Note moyenne',
                                                            data: this.data
                                                        }],
                                                        chart: {
                                                            type: 'bar',
                                                            height: '100%',
                                                            fontFamily: 'inherit',
                                                            toolbar: {
                                                                show: false
                                                            },
                                                            animations: {
                                                                enabled: true
                                                            }
                                                        },
                                                        plotOptions: {
                                                            bar: {
                                                                borderRadius: 4,
                                                                columnWidth: '60%',
                                                            }
                                                        },
                                                        dataLabels: {
                                                            enabled: false
                                                        },
                                                        colors: ['#10B981'], // emerald-500
                                                        xaxis: {
                                                            categories: this.labels,
                                                            labels: {
                                                                show: false
                                                            },
                                                            axisBorder: {
                                                                show: false
                                                            },
                                                            axisTicks: {
                                                                show: false
                                                            },
                                                            tooltip: {
                                                                enabled: false
                                                            }
                                                        },
                                                        yaxis: {
                                                            min: 0, 
                                                            max: 5,
                                                            tickAmount: 5,
                                                            labels: {
                                                                style: {
                                                                    colors: '#9CA3AF',
                                                                    fontSize: '10px'
                                                                },
                                                                formatter: (value) => value.toFixed(0)
                                                            }
                                                        },
                                                        grid: {
                                                            show: true,
                                                            borderColor: 'rgba(0,0,0,0.05)',
                                                            strokeDashArray: 4,
                                                            padding: {
                                                                top: 0,
                                                                right: 0,
                                                                bottom: 0,
                                                                left: 10
                                                            }
                                                        },
                                                        theme: {
                                                            mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                                                        },
                                                        tooltip: {
                                                            y: {
                                                                formatter: function (val) {
                                                                    return val + ' ⭐'
                                                                }
                                                            }
                                                        }
                                                    };

                                                    this.chart = new ApexCharts(this.$refs.chart, options);
                                                    this.chart.render();
                                                }
                                            }" x-init="init()" wire:ignore>
                    <div x-ref="chart" class="w-full h-full"></div>
                </div>
            </div>
        </div>
    @endif
</div>