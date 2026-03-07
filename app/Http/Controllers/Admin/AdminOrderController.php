<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['serviceListing', 'customer', 'provider'])->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['serviceListing', 'customer', 'provider']);

        return view('admin.orders.show', compact('order'));
    }
}