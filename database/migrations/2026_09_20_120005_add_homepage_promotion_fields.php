<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['activities', 'businesses', 'deals'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedInteger('featured_order')->default(0)->index();
                $table->timestamp('featured_from')->nullable()->index();
                $table->timestamp('featured_until')->nullable()->index();
            });
        }

        Schema::table('transfers', function (Blueprint $table) {
            $table->boolean('featured')->default(false)->index();
            $table->unsignedInteger('featured_order')->default(0)->index();
            $table->timestamp('featured_from')->nullable()->index();
            $table->timestamp('featured_until')->nullable()->index();
        });

        Schema::table('guesthouses', function (Blueprint $table) {
            $table->unsignedInteger('featured_priority')->default(0)->index();
            $table->timestamp('featured_start_at')->nullable()->index();
            $table->timestamp('featured_end_at')->nullable()->index();
        });

        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('advertiser');
            $table->string('placement')->index();
            $table->string('headline')->nullable();
            $table->text('copy')->nullable();
            $table->string('image')->nullable();
            $table->string('mobile_image')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('destination_url', 2048)->nullable();
            $table->unsignedInteger('priority')->default(0)->index();
            $table->timestamp('starts_at')->nullable()->index();
            $table->timestamp('ends_at')->nullable()->index();
            $table->boolean('active')->default(true)->index();
            $table->unsignedBigInteger('impressions')->default(0);
            $table->unsignedBigInteger('clicks')->default(0);
            $table->timestamps();
            $table->index(['placement', 'active', 'starts_at', 'ends_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisements');

        Schema::table('guesthouses', function (Blueprint $table) {
            $table->dropColumn(['featured_priority', 'featured_start_at', 'featured_end_at']);
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->dropColumn(['featured', 'featured_order', 'featured_from', 'featured_until']);
        });

        foreach (['activities', 'businesses', 'deals'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn(['featured_order', 'featured_from', 'featured_until']);
            });
        }
    }
};
