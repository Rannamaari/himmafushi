<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transfer_bookings', function (Blueprint $table) {
            $table->unsignedSmallInteger('passengers')->nullable()->after('children');
            $table->unsignedSmallInteger('infants')->nullable()->after('passengers');
        });
    }

    public function down(): void
    {
        Schema::table('transfer_bookings', function (Blueprint $table) {
            $table->dropColumn(['passengers', 'infants']);
        });
    }
};
