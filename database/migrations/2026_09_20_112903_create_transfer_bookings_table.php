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
        Schema::create('transfer_bookings', function (Blueprint $table) {
            $table->id();

            $table->string('reference')->nullable()->unique();

            $table->foreignId('transfer_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('customer_type');

            $table->string('name');

            $table->string('whatsapp', 40);

            $table->string('email')->nullable();

            $table->string('country')->nullable();

            $table->date('travel_date');

            $table->string('preferred_time')->nullable();

            $table->unsignedSmallInteger('adults')->default(1);

            $table->unsignedSmallInteger('children')->default(0);

            $table->string('flight_number')->nullable();

            $table->time('flight_time')->nullable();

            $table->string('pickup_location')->nullable();

            $table->string('dropoff_location')->nullable();

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
        Schema::dropIfExists('transfer_bookings');
    }
};
