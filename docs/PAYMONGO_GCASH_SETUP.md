# PayMongo + GCash Integration Guide (Laravel)

This guide is for your current LIMAX project.

## 1. Prerequisites

- PayMongo account
- GCash payment method enabled in PayMongo dashboard
- Laravel app running locally
- Public webhook URL (ngrok or deployed URL)

## 2. Environment Variables

Add these to `.env`:

```env
PAYMONGO_PUBLIC_KEY=pk_test_xxxxxxxxx
PAYMONGO_SECRET_KEY=sk_test_xxxxxxxxx
PAYMONGO_WEBHOOK_SECRET=whsec_xxxxxxxxx
PAYMONGO_BASE_URL=https://api.paymongo.com/v1
```

Then run:

```bash
php artisan config:clear
php artisan optimize:clear
```

## 3. Create a Payments Table (if not yet complete)

Your project already has a `payments` table. Ensure it stores at least:

- `order_id`
- `payment_reference` (PayMongo checkout session/payment intent id)
- `status` (`pending`, `paid`, `failed`, `refunded`)
- `payment_method` (`gcash`)
- `amount`, `currency`
- raw provider payload (JSON metadata)

## 4. Add Checkout Flow

When customer clicks **Pay with GCash**:

1. Create a local payment row with `status=pending`.
2. Call PayMongo Checkout API using your secret key.
3. Include `gcash` in enabled payment methods.
4. Redirect customer to PayMongo checkout URL.

### Suggested controller file

Create: `app/Http/Controllers/PaymentController.php`

Main actions:

- `startGcash(Order $order)` -> creates PayMongo checkout session
- `webhook(Request $request)` -> verifies event and updates local `payments` + `orders`
- `success()` and `failed()` optional return pages

## 5. Add Routes

In `routes/web.php`:

```php
Route::middleware('auth')->group(function () {
    Route::post('/orders/{order}/pay/gcash', [PaymentController::class, 'startGcash'])
        ->name('payments.gcash.start');

    Route::get('/payments/success', [PaymentController::class, 'success'])
        ->name('payments.success');

    Route::get('/payments/failed', [PaymentController::class, 'failed'])
        ->name('payments.failed');
});

Route::post('/webhooks/paymongo', [PaymentController::class, 'webhook'])
    ->name('webhooks.paymongo');
```

## 6. PayMongo Request Pattern

Use Laravel HTTP client:

```php
Http::withBasicAuth(config('services.paymongo.secret_key'), '')
    ->post(config('services.paymongo.base_url').'/checkout_sessions', [...]);
```

Important fields:

- `line_items` from order amount
- `payment_method_types` => `['gcash']`
- `success_url` and `cancel_url`
- metadata with local `order_id`

## 7. Webhook (Critical)

Never trust frontend redirect alone.

Webhook must:

1. Validate signature (PayMongo webhook secret)
2. Parse event type (`checkout_session.payment.paid`, etc.)
3. Find local payment/order by checkout session id or metadata order id
4. Update local records:
   - `payments.status = paid`
   - `orders.payment_status = paid`
   - optional `orders.status = confirmed`

## 8. UI Changes

- Add button in order details page:
  - **Pay with GCash**
- Disable button if already paid.
- Show pending/paid badge clearly.

## 9. Testing Checklist

1. Create test order as customer
2. Click **Pay with GCash**
3. Ensure redirect to PayMongo checkout page
4. Complete test payment
5. Verify webhook received
6. Verify DB updates:
   - payment row -> `paid`
   - order payment_status -> `paid`
7. Verify admin/provider/customer pages reflect paid status

## 10. Production Notes

- Use live keys in production env only
- Keep keys out of git
- Add retry/idempotency handling in webhook
- Log webhook payloads for audit/debug

---

## Suggested Next Implementation Files

- `app/Http/Controllers/PaymentController.php`
- `app/Services/PayMongoService.php`
- `config/services.php` (paymongo section)
- `resources/views/pages/orders/show.blade.php` (Pay with GCash button)
- `routes/web.php` (payment + webhook routes)

If you want, next step is I implement these files directly in your codebase.
