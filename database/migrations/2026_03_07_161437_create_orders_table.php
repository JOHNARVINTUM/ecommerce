<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('provider_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_listing_id')->constrained('service_listings')->cascadeOnDelete();

            $table->string('order_number')->unique();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('PHP');

            $table->date('scheduled_date')->nullable();
            $table->time('scheduled_time')->nullable();

            $table->string('status')->default('pending');
            $table->string('payment_status')->default('unpaid');

            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->text('customer_address')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['customer_user_id', 'status']);
            $table->index(['provider_user_id', 'status']);
            $table->index(['service_listing_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};