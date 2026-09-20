<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('navigation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('navigation_items')->cascadeOnDelete();
            $table->string('key')->unique();
            $table->string('label');
            $table->string('route_name')->nullable();
            $table->string('url', 2048)->nullable();
            $table->string('active_route_pattern')->nullable();
            $table->string('menu_style')->default('link');
            $table->string('menu_heading')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('show_in_desktop')->default(true);
            $table->boolean('show_in_mobile')->default(true);
            $table->boolean('open_in_new_tab')->default(false);
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
        });

        Schema::table('advertisements', function (Blueprint $table) {
            $table->longText('embed_code')->nullable()->after('destination_url');
        });
    }

    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn('embed_code');
        });

        Schema::dropIfExists('navigation_items');
    }
};
