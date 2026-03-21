@extends('layouts.admin')

@section('content')
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Completed Orders</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">{{ $successfulProjects }}</h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">On Going Orders</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">{{ $inProgressProjects }}</h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Cancelled</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">{{ $cancelledProjects }}</h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Orders</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">{{ $totalOrders }}</h2>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        <div
            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2"
            x-data="ordersOverviewChart(@js($orderChartData), @js($statusOrder), @js($statusLabels))"
        >
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h3 class="text-lg font-semibold text-slate-900">Orders Overview</h3>
                <div class="flex flex-wrap items-center gap-2">
                    <div class="inline-flex overflow-hidden rounded-lg border border-slate-200">
                        <button type="button" class="px-3 py-2 text-xs font-semibold"
                            :class="selectedRange === 'all' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
                            @click="selectedRange = 'all'">
                            All Time
                        </button>
                        <button type="button" class="border-l border-slate-200 px-3 py-2 text-xs font-semibold"
                            :class="selectedRange === '30d' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
                            @click="selectedRange = '30d'">
                            30 Days
                        </button>
                        <button type="button" class="border-l border-slate-200 px-3 py-2 text-xs font-semibold"
                            :class="selectedRange === '7d' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700'"
                            @click="selectedRange = '7d'">
                            7 Days
                        </button>
                    </div>

                    <div class="inline-flex overflow-hidden rounded-lg border border-slate-200">
                        <button type="button" class="px-3 py-2 text-xs font-semibold"
                            :class="chartType === 'bar' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-700'"
                            @click="chartType = 'bar'">
                            Bar
                        </button>
                        <button type="button" class="border-l border-slate-200 px-3 py-2 text-xs font-semibold"
                            :class="chartType === 'line' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-700'"
                            @click="chartType = 'line'">
                            Line
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                <div class="rounded-xl bg-slate-50 px-4 py-3">
                    <p class="text-xs text-slate-500">Total Orders</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900" x-text="current.total"></p>
                </div>
                <div class="rounded-xl bg-emerald-50 px-4 py-3">
                    <p class="text-xs text-emerald-700">Completed</p>
                    <p class="mt-1 text-2xl font-bold text-emerald-800" x-text="current.status_counts.completed ?? 0"></p>
                </div>
                <div class="rounded-xl bg-amber-50 px-4 py-3">
                    <p class="text-xs text-amber-700">On Going</p>
                    <p class="mt-1 text-2xl font-bold text-amber-800" x-text="current.status_counts.in_progress ?? 0"></p>
                </div>
            </div>

            <div class="mt-6 rounded-xl border border-slate-200 bg-slate-50 p-4">
                <svg viewBox="0 0 640 280" class="h-64 w-full">
                    <line x1="50" y1="20" x2="50" y2="240" stroke="#cbd5e1" stroke-width="1" />
                    <line x1="50" y1="240" x2="610" y2="240" stroke="#cbd5e1" stroke-width="1" />

                    <template x-for="tick in [0, 0.25, 0.5, 0.75, 1]" :key="tick">
                        <g>
                            <line :x1="50" :x2="610" :y1="240 - (220 * tick)" :y2="240 - (220 * tick)" stroke="#e2e8f0" stroke-width="1" />
                            <text x="8" :y="244 - (220 * tick)" class="fill-slate-500 text-[10px]" x-text="Math.round((current.max_count ?? 1) * tick)"></text>
                        </g>
                    </template>

                    <g x-show="chartType === 'bar'">
                            <template x-for="(status, index) in statusOrder" :key="status">
                                <g>
                                    <rect
                                        :x="xPos(index) - 22"
                                        :y="yPos(value(status))"
                                        width="44"
                                        :height="240 - yPos(value(status))"
                                        rx="4"
                                        fill="#334155"
                                    ></rect>
                                    <text :x="xPos(index)" :y="yPos(value(status)) - 8" text-anchor="middle" class="fill-slate-700 text-[10px] font-semibold" x-text="value(status)"></text>
                                </g>
                            </template>
                    </g>

                    <g x-show="chartType === 'line'">
                            <polyline :points="linePoints()" fill="none" stroke="#1d4ed8" stroke-width="3"></polyline>
                            <template x-for="(status, index) in statusOrder" :key="status + '-dot'">
                                <g>
                                    <circle :cx="xPos(index)" :cy="yPos(value(status))" r="4" fill="#1d4ed8"></circle>
                                    <text :x="xPos(index)" :y="yPos(value(status)) - 10" text-anchor="middle" class="fill-slate-700 text-[10px] font-semibold" x-text="value(status)"></text>
                                </g>
                            </template>
                    </g>
                </svg>

                <div class="mt-2 grid grid-cols-5 gap-2 text-center">
                    <template x-for="(status, index) in statusOrder" :key="status + '-label'">
                        <p class="text-xs font-medium text-slate-600" x-text="statusLabels[status]"></p>
                    </template>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900">Recent Status</h3>
            <div class="mt-4 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Pending Orders</span>
                    <x-status-badge status="pending" />
                    <span class="text-sm font-semibold text-slate-900">{{ $orderChartData['all']['status_counts']['pending'] ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Completed Orders</span>
                    <x-status-badge status="completed" />
                    <span class="text-sm font-semibold text-slate-900">{{ $orderChartData['all']['status_counts']['completed'] ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Cancelled Orders</span>
                    <x-status-badge status="cancelled" />
                    <span class="text-sm font-semibold text-slate-900">{{ $orderChartData['all']['status_counts']['cancelled'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Recent Notifications</h3>
            <a href="{{ route('admin.notifications.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                View all
            </a>
        </div>

        <div class="mt-4 space-y-3">
            @forelse ($adminNotifications as $notification)
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                    <p class="text-sm font-medium text-slate-800">{{ $notification['message'] }}</p>
                    <p class="mt-1 text-xs text-slate-500">{{ $notification['time'] ?? 'Just now' }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-500">No notifications yet.</p>
            @endforelse
        </div>
    </div>

    <script>
        function ordersOverviewChart(orderChartData, statusOrder, statusLabels) {
            return {
                orderChartData,
                statusOrder,
                statusLabels,
                selectedRange: 'all',
                chartType: 'bar',
                get current() {
                    return this.orderChartData[this.selectedRange] ?? this.orderChartData.all;
                },
                value(status) {
                    return this.current?.status_counts?.[status] ?? 0;
                },
                xPos(index) {
                    const count = this.statusOrder.length || 1;
                    const width = 560;
                    const step = width / count;
                    return 50 + (step * index) + (step / 2);
                },
                yPos(value) {
                    const max = this.current?.max_count ?? 1;
                    const ratio = max > 0 ? (value / max) : 0;
                    return 240 - (ratio * 220);
                },
                linePoints() {
                    return this.statusOrder
                        .map((status, index) => `${this.xPos(index)},${this.yPos(this.value(status))}`)
                        .join(' ');
                },
            };
        }
    </script>
@endsection
