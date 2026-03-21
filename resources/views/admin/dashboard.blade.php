@extends('layouts.admin')

@section('content')
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-white bg-white/60 p-6 shadow-lg">
            <p class="text-sm text-white/80">Completed Orders</p>
            <h2 class="mt-3 text-3xl font-bold text-white">{{ $successfulProjects }}</h2>
        </div>

        <div class="rounded-2xl border border-white bg-white/60 p-6 shadow-lg">
            <p class="text-sm text-white/80">On Going Orders</p>
            <h2 class="mt-3 text-3xl font-bold text-white">{{ $inProgressProjects }}</h2>
        </div>

        <div class="rounded-2xl border border-white bg-white/60 p-6 shadow-lg">
            <p class="text-sm text-white/80">Cancelled</p>
            <h2 class="mt-3 text-3xl font-bold text-white">{{ $cancelledProjects }}</h2>
        </div>

        <div class="rounded-2xl border border-white bg-white/60 p-6 shadow-lg">
            <p class="text-sm text-white/80">Total Orders</p>
            <h2 class="mt-3 text-3xl font-bold text-white">{{ $totalOrders }}</h2>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        <div
            class="rounded-2xl border border-white bg-white/60 p-6 shadow-lg lg:col-span-2"
            x-data="window.ordersOverviewChart(@js($orderChartData), @js($statusOrder), @js($statusLabels))"
        >
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h3 class="text-lg font-semibold text-white">Orders Overview</h3>
                <div class="inline-flex overflow-hidden rounded-lg border border-white">
                    <button type="button" class="px-3 py-2 text-xs font-semibold"
                        :class="selectedRange === 'all' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
                        @click="selectedRange = 'all'">
                        All Time
                    </button>
                    <button type="button" class="border-l border-slate-200 px-3 py-2 text-xs font-semibold"
                        :class="selectedRange === 'month' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
                        @click="selectedRange = 'month'">
                        This Month
                    </button>
                    <button type="button" class="border-l border-slate-200 px-3 py-2 text-xs font-semibold"
                        :class="selectedRange === '7d' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
                        @click="selectedRange = '7d'">
                        7 Days
                    </button>
                </div>
            </div>

            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                <div class="rounded-xl border border-white bg-white/30 px-4 py-3">
                    <p class="text-xs text-white/80">Total Orders</p>
                    <p class="mt-1 text-2xl font-bold text-white" x-text="current.total"></p>
                </div>
                <div class="rounded-xl border border-white bg-white/30 px-4 py-3">
                    <p class="text-xs text-white/80">Completed</p>
                    <p class="mt-1 text-2xl font-bold text-white" x-text="current.status_counts.completed ?? 0"></p>
                </div>
                <div class="rounded-xl border border-white bg-white/30 px-4 py-3">
                    <p class="text-xs text-white/80">On Going</p>
                    <p class="mt-1 text-2xl font-bold text-white" x-text="current.status_counts.in_progress ?? 0"></p>
                </div>
            </div>

            <div class="relative mt-6 rounded-xl border border-white bg-white/30 p-4">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <p class="text-sm font-semibold text-white" x-text="current.series_label"></p>
                    <p class="text-xs text-white/80" x-text="rangeDescription()"></p>
                </div>

                <div
                    x-show="hoveredPoint"
                    x-cloak
                    class="pointer-events-none absolute z-10 w-28 rounded-lg bg-slate-950 px-3 py-2 text-white shadow-lg"
                    :style="`left: ${tooltipX()}px; top: ${tooltipY()}px;`"
                >
                    <p class="text-[10px] font-medium text-slate-300" x-text="hoveredPoint ? hoveredPoint.label : ''"></p>
                    <p class="mt-1 text-xs font-semibold" x-text="hoveredPoint ? `${hoveredPoint.value} orders` : ''"></p>
                </div>

                <svg viewBox="0 0 640 280" class="h-64 w-full" @mouseleave="clearHover()">
                    <text x="22" y="18" class="fill-slate-500 text-[10px] font-semibold">Y: Orders</text>
                    <line x1="50" y1="20" x2="50" y2="240" stroke="#cbd5e1" stroke-width="1" />
                    <line x1="50" y1="240" x2="610" y2="240" stroke="#cbd5e1" stroke-width="1" />

                    <template x-for="tick in [0, 0.25, 0.5, 0.75, 1]" :key="tick">
                        <g>
                            <line :x1="50" :x2="610" :y1="240 - (220 * tick)" :y2="240 - (220 * tick)" stroke="#e2e8f0" stroke-width="1" />
                            <text x="8" :y="244 - (220 * tick)" class="fill-slate-500 text-[10px]" x-text="Math.round((current.max_count ?? 1) * tick)"></text>
                        </g>
                    </template>

                    <polyline :points="linePoints()" fill="none" stroke="#1d4ed8" stroke-width="3"></polyline>
                    <template x-for="(point, index) in current.values" :key="'dot-' + index">
                        <g>
                            <rect
                                :x="bandStart(index)"
                                y="20"
                                :width="bandWidth()"
                                height="220"
                                fill="transparent"
                                @mouseenter="setHover(index)"
                            ></rect>
                            <line
                                :x1="xPos(index)"
                                :x2="xPos(index)"
                                y1="20"
                                y2="240"
                                :stroke="hoveredIndex === index ? '#bfdbfe' : 'transparent'"
                                stroke-width="1"
                            ></line>
                            <circle
                                :cx="xPos(index)"
                                :cy="yPos(point)"
                                :r="hoveredIndex === index ? 6 : 4"
                                fill="#1d4ed8"
                                @mouseenter="setHover(index)"
                            ></circle>
                            <circle
                                :cx="xPos(index)"
                                :cy="yPos(point)"
                                r="16"
                                fill="transparent"
                                @mouseenter="setHover(index)"
                            ></circle>
                            <text :x="xPos(index)" :y="yPos(point) - 10" text-anchor="middle" class="fill-slate-700 text-[10px] font-semibold" x-text="point"></text>
                        </g>
                    </template>
                </svg>

                <div class="mt-3 flex items-center justify-between text-xs text-white/80">
                    <span class="font-semibold">X: <span x-text="xAxisLabel()"></span></span>
                    <span>Y: Number of orders</span>
                </div>

                <div class="mt-2" :class="labelGridClass()">
                    <template x-for="(label, index) in current.labels" :key="'label-' + index">
                        <p class="text-center text-xs font-medium text-white/80" x-text="label"></p>
                    </template>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-white bg-white/60 p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-white">Recent Status</h3>
            <div class="mt-4 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-white/80">Pending Orders</span>
                    <x-status-badge status="pending" />
                    <span class="text-sm font-semibold text-white">{{ $orderChartData['all']['status_counts']['pending'] ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-sm text-white/80">Completed Orders</span>
                    <x-status-badge status="completed" />
                    <span class="text-sm font-semibold text-white">{{ $orderChartData['all']['status_counts']['completed'] ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-sm text-white/80">Cancelled Orders</span>
                    <x-status-badge status="cancelled" />
                    <span class="text-sm font-semibold text-white">{{ $orderChartData['all']['status_counts']['cancelled'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 rounded-2xl border border-white bg-white/60 p-6 shadow-lg">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-white">Recent Notifications</h3>
            <a href="{{ route('admin.notifications.index') }}" class="text-sm font-medium text-indigo-100 hover:text-white">
                View all
            </a>
        </div>

        <div class="mt-4 space-y-3">
            @forelse ($adminNotifications as $notification)
                <div class="rounded-xl border border-white bg-white/30 px-4 py-3">
                    <p class="text-sm font-medium text-white">{{ $notification['message'] }}</p>
                    <p class="mt-1 text-xs text-white/80">{{ $notification['time'] ?? 'Just now' }}</p>
                </div>
            @empty
                <p class="text-sm text-white/80">No notifications yet.</p>
            @endforelse
        </div>
    </div>
@endsection
