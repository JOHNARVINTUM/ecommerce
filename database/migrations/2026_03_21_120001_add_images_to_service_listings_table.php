<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_listings', function (Blueprint $table) {
            $table->string('thumbnail_path')->nullable()->after('revisions');
            $table->json('gallery_images')->nullable()->after('thumbnail_path');
        });
    }

    public function down(): void
    {
        Schema::table('service_listings', function (Blueprint $table) {
            $table->dropColumn(['thumbnail_path', 'gallery_images']);
        });
    }
};
