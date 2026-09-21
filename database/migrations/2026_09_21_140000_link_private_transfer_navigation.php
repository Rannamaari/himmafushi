<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('navigation_items')->where('key', 'private-transfers')->update([
            'route_name' => 'private-transfers',
            'url' => null,
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('navigation_items')->where('key', 'private-transfers')->update([
            'route_name' => 'transfers.index',
            'updated_at' => now(),
        ]);
    }
};
