<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('navigation_items')->where('key', 'atolliva-maldives')->update([
            'label' => 'About Us',
            'route_name' => 'about',
            'active_route_pattern' => 'about',
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('navigation_items')->where('key', 'atolliva-maldives')->update([
            'label' => 'Atolliva Maldives',
            'route_name' => 'atolliva',
            'active_route_pattern' => 'atolliva',
            'updated_at' => now(),
        ]);
    }
};
