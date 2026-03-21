<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
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
        $ranges = [
            'all' => null,
            '7d' => Carbon::today()->subDays(6)->startOfDay(),
            '30d' => Carbon::today()->subDays(29)->startOfDay(),
        ];

        $orderChartData = [];

        foreach ($ranges as $rangeKey => $startDate) {
            $query = Order::query();

            if ($startDate) {
                $query->where('created_at', '>=', $startDate);
            }

            $grouped = (clone $query)
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            $statusCounts = [];
            foreach ($statusOrder as $status) {
                $statusCounts[$status] = (int) ($grouped[$status] ?? 0);
            }

            $total = array_sum($statusCounts);

            $orderChartData[$rangeKey] = [
                'total' => $total,
                'status_counts' => $statusCounts,
                'max_count' => max(1, ...array_values($statusCounts)),
            ];
        }

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
}
