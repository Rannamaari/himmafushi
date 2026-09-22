<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guesthouses', function (Blueprint $table) {
            $table->text('excerpt')->nullable()->after('slug');
            $table->json('gallery')->nullable()->after('image');
            $table->unsignedSmallInteger('display_priority')->default(0)->after('gallery')->index();
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->json('gallery')->nullable()->after('cover_image');
            $table->unsignedSmallInteger('display_priority')->default(0)->after('gallery')->index();
        });
    }

    public function down(): void
    {
        Schema::table('guesthouses', function (Blueprint $table) {
            $table->dropIndex(['display_priority']);
            $table->dropColumn(['excerpt', 'gallery', 'display_priority']);
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->dropIndex(['display_priority']);
            $table->dropColumn(['gallery', 'display_priority']);
        });
    }
};
