<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['profile']);

        $customerOrders = collect();
        $latestCustomerOrder = null;
        $orderStats = [
            'total' => 0,
            'completed' => 0,
            'ongoing' => 0,
            'cancelled' => 0,
        ];

        if ($user->role === User::ROLE_CUSTOMER) {
            $customerOrders = Order::with(['serviceListing', 'provider'])
                ->where('customer_user_id', $user->id)
                ->latest()
                ->paginate(10);

            $latestCustomerOrder = Order::where('customer_user_id', $user->id)
                ->latest()
                ->first();

            $orderStats = [
                'total' => Order::where('customer_user_id', $user->id)->count(),
                'completed' => Order::where('customer_user_id', $user->id)->where('status', Order::STATUS_COMPLETED)->count(),
                'ongoing' => Order::where('customer_user_id', $user->id)->whereIn('status', [Order::STATUS_PENDING, Order::STATUS_CONFIRMED, Order::STATUS_IN_PROGRESS])->count(),
                'cancelled' => Order::where('customer_user_id', $user->id)->where('status', Order::STATUS_CANCELLED)->count(),
            ];
        }

        return view('admin.users.show', compact('user', 'customerOrders', 'latestCustomerOrder', 'orderStats'));
    }
}
