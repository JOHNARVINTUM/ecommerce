<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PayMongoService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private readonly PayMongoService $payMongoService)
    {
    }

    public function index()
    {
        $user = auth()->user();

        abort_unless($user && $user->role === 'customer', 403);

        $orders = Order::with(['serviceListing', 'provider'])
            ->where('customer_user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('pages.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = auth()->user();

        abort_unless($user && $user->role === 'customer', 403);
        abort_unless($order->customer_user_id === $user->id, 403);

        $order->load(['serviceListing', 'provider', 'payments']);

        if ($order->payment_status !== Order::PAYMENT_PAID) {
            try {
                $this->payMongoService->syncOrderPaymentStatus($order);
                $order->refresh()->load(['serviceListing', 'provider', 'payments']);
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        return view('pages.orders.show', compact('order'));
    }
}
