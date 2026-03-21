<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body style="margin:0;padding:24px;background:#f6f7fb;font-family:Arial,sans-serif;color:#111827;">
    <div style="max-width:640px;margin:0 auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;">
        <h1 style="margin:0 0 12px;font-size:22px;color:#0f172a;">Order Confirmed</h1>
        <p style="margin:0 0 16px;font-size:14px;line-height:1.6;color:#374151;">
            Hi {{ $order->customer_name }}, your order has been placed successfully.
        </p>

        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:14px 16px;">
            <p style="margin:0 0 8px;font-size:14px;"><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p style="margin:0 0 8px;font-size:14px;"><strong>Service:</strong> {{ $order->serviceListing->title ?? 'N/A' }}</p>
            <p style="margin:0 0 8px;font-size:14px;"><strong>Amount:</strong> {{ $order->currency }} {{ number_format($order->amount, 2) }}</p>
            <p style="margin:0 0 8px;font-size:14px;"><strong>Status:</strong> {{ $order->status_label }}</p>
            <p style="margin:0;font-size:14px;"><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
        </div>

        <p style="margin:16px 0 0;font-size:13px;line-height:1.6;color:#6b7280;">
            This email verifies that your order was created in LIMAX. Keep this message for your records.
        </p>
    </div>
</body>
</html>
