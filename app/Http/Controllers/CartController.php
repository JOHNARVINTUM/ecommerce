<?php

namespace App\Http\Controllers;

use App\Models\ServiceListing;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        abort_unless($user && $user->role === 'customer', 403);

        $cart = collect(session('cart', []))
            ->map(function (array $item) {
                $quantity = max(1, (int) ($item['quantity'] ?? 1));
                $unitPrice = (float) ($item['unit_price'] ?? $item['amount'] ?? 0);
                $item['quantity'] = $quantity;
                $item['unit_price'] = $unitPrice;
                $item['item_total'] = $quantity * $unitPrice;

                return $item;
            })
            ->values();

        $subtotal = $cart->sum(fn ($item) => (float) ($item['item_total'] ?? 0));
        $itemCount = $cart->sum(fn ($item) => (int) ($item['quantity'] ?? 0));
        $tax = round($subtotal * 0.015, 2);
        $total = round($subtotal + $tax, 2);
        $deliveryTimeDays = (int) $cart->max(fn ($item) => (int) ($item['delivery_time_days'] ?? 0));
        $deliveryTimeDays = max(1, $deliveryTimeDays);

        return view('pages.cart.index', [
            'cartItems' => $cart,
            'cartSubtotal' => $subtotal,
            'cartTax' => $tax,
            'cartTotal' => $total,
            'cartItemCount' => $itemCount,
            'cartDeliveryDays' => $deliveryTimeDays,
        ]);
    }

    public function store(Request $request, ServiceListing $service)
    {
        $user = auth()->user();
        abort_unless($user && $user->role === 'customer', 403);
        abort_unless($service->is_active, 404);

        $cart = session('cart', []);
        $currentQuantity = (int) ($cart[$service->id]['quantity'] ?? 0);
        $quantity = max(1, $currentQuantity + 1);

        $cart[$service->id] = [
            'service_id' => $service->id,
            'slug' => $service->slug,
            'title' => $service->title,
            'provider_name' => $service->provider->name ?? 'Provider',
            'unit_price' => (float) $service->price,
            'currency' => $service->currency ?: 'PHP',
            'quantity' => $quantity,
            'delivery_time_days' => (int) ($service->delivery_time_days ?? 1),
        ];

        session(['cart' => $cart]);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Service added to cart.');
    }

    public function updateQuantity(Request $request, ServiceListing $service)
    {
        $user = auth()->user();
        abort_unless($user && $user->role === 'customer', 403);

        $action = $request->validate([
            'action' => ['required', 'in:increase,decrease'],
        ])['action'];

        $cart = session('cart', []);
        if (! isset($cart[$service->id])) {
            return redirect()->route('cart.index');
        }

        $quantity = (int) ($cart[$service->id]['quantity'] ?? 1);
        $quantity = $action === 'increase' ? $quantity + 1 : max(1, $quantity - 1);
        $cart[$service->id]['quantity'] = $quantity;

        session(['cart' => $cart]);

        return redirect()->route('cart.index');
    }

    public function destroy(ServiceListing $service)
    {
        $user = auth()->user();
        abort_unless($user && $user->role === 'customer', 403);

        $cart = session('cart', []);
        unset($cart[$service->id]);
        session(['cart' => $cart]);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Service removed from cart.');
    }

    public function clear()
    {
        $user = auth()->user();
        abort_unless($user && $user->role === 'customer', 403);

        session()->forget('cart');

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart cleared.');
    }
}
