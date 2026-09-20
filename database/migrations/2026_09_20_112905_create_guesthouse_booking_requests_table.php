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
        Schema::create('guesthouse_booking_requests', function (Blueprint $table) {
            $table->id();

            $table->string('reference')->nullable()->unique();

            $table->foreignId('guesthouse_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('customer_type');

            $table->string('name');

            $table->string('whatsapp', 40);

            $table->string('email')->nullable();

            $table->string('country')->nullable();

            $table->date('check_in');

            $table->date('check_out');

            $table->unsignedSmallInteger('adults')->default(1);

            $table->unsignedSmallInteger('children')->default(0);

            $table->string('room_preference')->nullable();

            $table->string('meal_plan')->nullable();

            $table->text('notes')->nullable();

            $table->string('status')
                ->default('new')
                ->index();

            $table->decimal('quote_amount', 10, 2)->nullable();

            $table->string('quote_currency', 3)->nullable();

            $table->text('supplier_confirmation')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guesthouse_booking_requests');
    }
};
