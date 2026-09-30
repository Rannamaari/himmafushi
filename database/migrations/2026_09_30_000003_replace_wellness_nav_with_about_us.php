<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('navigation_items')->where('key', 'wellness')->update([
            'show_in_desktop' => false,
            'show_in_mobile' => false,
            'updated_at' => now(),
        ]);

        DB::table('navigation_items')->where('key', 'atolliva-maldives')->update([
            'sort_order' => 60,
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('navigation_items')->where('key', 'wellness')->update([
            'show_in_desktop' => true,
            'show_in_mobile' => true,
            'updated_at' => now(),
        ]);

        DB::table('navigation_items')->where('key', 'atolliva-maldives')->update([
            'sort_order' => 80,
            'updated_at' => now(),
        ]);
    }
};
