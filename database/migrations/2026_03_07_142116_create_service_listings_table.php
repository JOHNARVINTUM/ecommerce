<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('provider_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description');
            $table->longText('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 10)->default('PHP');
            $table->unsignedInteger('sold_count')->default(0);
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->unsignedInteger('rating_count')->default(0);
            $table->unsignedInteger('delivery_time_days')->nullable();
            $table->unsignedInteger('revisions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('service_category_id');
            $table->index('provider_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_listings');
    }
};