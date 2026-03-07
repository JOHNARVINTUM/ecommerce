<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ServiceListing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(ServiceListing $service)
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in first to continue your booking.');
        }

        if (auth()->user()->role !== 'customer') {
            return redirect()->back()->with('error', 'Only customers can place orders.');
        }

        return view('pages.checkout.create', [
            'service' => $service,
        ]);
    }

    public function store(Request $request, ServiceListing $service)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'customer') {
            abort(403, 'Only customers can place orders.');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:255'],
            'customer_address' => ['nullable', 'string'],
            'scheduled_date' => ['nullable', 'date', 'after_or_equal:today'],
            'scheduled_time' => ['nullable'],
            'notes' => ['nullable', 'string'],
        ]);

        $order = Order::create([
            'customer_user_id' => auth()->id(),
            'provider_user_id' => $service->provider_user_id,
            'service_listing_id' => $service->id,
            'order_number' => 'LIMAX-' . strtoupper(Str::random(10)),
            'amount' => $service->price,
            'currency' => 'PHP',
            'scheduled_date' => $validated['scheduled_date'] ?? null,
            'scheduled_time' => $validated['scheduled_time'] ?? null,
            'status' => Order::STATUS_PENDING,
            'payment_status' => Order::PAYMENT_UNPAID,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'customer_address' => $validated['customer_address'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Your booking has been placed successfully.');
    }
}