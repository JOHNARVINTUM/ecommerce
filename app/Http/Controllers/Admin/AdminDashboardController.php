<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $successfulProjects = Order::where('status', Order::STATUS_COMPLETED)->count();
        $inProgressProjects = Order::where('status', Order::STATUS_IN_PROGRESS)->count();
        $cancelledProjects = Order::where('status', Order::STATUS_CANCELLED)->count();
        $totalOrders = Order::count();
        $statusOrder = [
            Order::STATUS_PENDING,
            Order::STATUS_CONFIRMED,
            Order::STATUS_IN_PROGRESS,
            Order::STATUS_COMPLETED,
            Order::STATUS_CANCELLED,
        ];
        $statusLabels = [
            Order::STATUS_PENDING => 'Pending',
            Order::STATUS_CONFIRMED => 'Confirmed',
            Order::STATUS_IN_PROGRESS => 'On Going',
            Order::STATUS_COMPLETED => 'Completed',
            Order::STATUS_CANCELLED => 'Cancelled',
        ];
        $allStatusCounts = $this->buildStatusCounts(Order::query(), $statusOrder);

        $lastSevenDays = collect(range(0, 6))
            ->map(fn (int $offset) => $today->copy()->subDays(6 - $offset)->startOfDay());
        $weeklyDates = $lastSevenDays->map(fn (Carbon $date) => $date->toDateString())->all();
        $dailyOrders = Order::query()
            ->whereDate('created_at', '>=', $lastSevenDays->first()->toDateString())
            ->selectRaw('DATE(created_at) as order_date, COUNT(*) as total')
            ->groupBy('order_date')
            ->pluck('total', 'order_date');

        $currentMonthStart = $today->copy()->startOfMonth();
        $currentMonthEnd = $today->copy()->endOfMonth();
        $monthOrders = Order::query()
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->get(['created_at']);
        $weeksInMonth = (int) ceil($currentMonthStart->daysInMonth / 7);
        $weeklyBuckets = array_fill(0, $weeksInMonth, 0);

        foreach ($monthOrders as $order) {
            $dayOfMonth = Carbon::parse($order->created_at)->day;
            $weekIndex = (int) floor(($dayOfMonth - 1) / 7);
            $weeklyBuckets[$weekIndex]++;
        }

        $orderChartData = [
            'all' => [
                'total' => array_sum($allStatusCounts),
                'status_counts' => $allStatusCounts,
                'max_count' => max(1, ...array_values($allStatusCounts)),
                'labels' => array_map(fn (string $status) => $statusLabels[$status], $statusOrder),
                'values' => array_map(fn (string $status) => $allStatusCounts[$status], $statusOrder),
                'series_label' => 'Orders by Status',
            ],
            'month' => [
                'total' => array_sum($weeklyBuckets),
                'status_counts' => $this->buildStatusCounts(
                    Order::query()->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd]),
                    $statusOrder
                ),
                'max_count' => max(1, ...$weeklyBuckets),
                'labels' => collect(range(1, $weeksInMonth))
                    ->map(fn (int $week) => "Week {$week}")
                    ->all(),
                'values' => $weeklyBuckets,
                'series_label' => 'Orders Per Week',
            ],
            '7d' => [
                'total' => array_sum(array_map(fn (string $date) => (int) ($dailyOrders[$date] ?? 0), $weeklyDates)),
                'status_counts' => $this->buildStatusCounts(
                    Order::query()->whereDate('created_at', '>=', $lastSevenDays->first()->toDateString()),
                    $statusOrder
                ),
                'max_count' => max(1, ...array_map(fn (string $date) => (int) ($dailyOrders[$date] ?? 0), $weeklyDates)),
                'labels' => $lastSevenDays->map(fn (Carbon $date) => $date->format('M j'))->all(),
                'values' => array_map(fn (string $date) => (int) ($dailyOrders[$date] ?? 0), $weeklyDates),
                'series_label' => 'Orders Per Day',
            ],
        ];

        $adminNotifications = Order::with(['customer', 'provider', 'serviceListing'])
            ->latest()
            ->limit(8)
            ->get()
            ->map(function (Order $order) {
                $statusLabel = $order->status_label;
                $customerName = $order->customer->name ?? $order->customer_name;
                $serviceTitle = $order->serviceListing->title ?? 'service';

                return [
                    'order_number' => $order->order_number,
                    'status_label' => $statusLabel,
                    'message' => "Order {$order->order_number}: {$customerName} requested {$serviceTitle}. Status: {$statusLabel}.",
                    'time' => $order->updated_at?->diffForHumans(),
                ];
            });

        return view('admin.dashboard', compact(
            'successfulProjects',
            'inProgressProjects',
            'cancelledProjects',
            'totalOrders',
            'orderChartData',
            'statusOrder',
            'statusLabels',
            'adminNotifications'
        ));
    }

    private function buildStatusCounts($query, array $statusOrder): array
    {
        $grouped = (clone $query)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusCounts = [];

        foreach ($statusOrder as $status) {
            $statusCounts[$status] = (int) ($grouped[$status] ?? 0);
        }

        return $statusCounts;
    }
}
