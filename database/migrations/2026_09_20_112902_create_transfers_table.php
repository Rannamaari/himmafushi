<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('from_location');
            $table->string('to_location');

            $table->string('type')->default('scheduled_speedboat');

            $table->time('departure_time')->nullable();

            $table->json('operating_days')->nullable();

            $table->decimal('local_price', 10, 2)->nullable();
            $table->decimal('tourist_price', 10, 2)->nullable();

            $table->string('tourist_currency', 3)->default('USD');

            $table->unsignedSmallInteger('duration_minutes')->nullable();

            $table->text('notes')->nullable();

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
