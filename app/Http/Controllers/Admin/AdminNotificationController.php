<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $notifications = Order::with(['customer', 'provider', 'serviceListing'])
            ->latest()
            ->limit(30)
            ->get()
            ->map(function (Order $order) {
                return [
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'status_label' => $order->status_label,
                    'status_color' => $order->status_color,
                    'message' => sprintf(
                        'Order %s updated for %s (%s).',
                        $order->order_number,
                        $order->customer->name ?? $order->customer_name,
                        $order->serviceListing->title ?? 'service'
                    ),
                    'time' => $order->updated_at?->diffForHumans(),
                ];
            });

        return view('admin.notifications.index', compact('notifications'));
    }
}
