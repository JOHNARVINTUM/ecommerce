<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provider_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('display_name');
            $table->string('headline');
            $table->text('bio')->nullable();
            $table->string('country')->nullable();
            $table->string('languages')->nullable();
            $table->string('response_time')->nullable();
            $table->string('last_delivery_note')->nullable();
            $table->date('member_since')->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('github_url')->nullable();
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_profiles');
    }
};