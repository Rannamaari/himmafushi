<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('navigation_items')->insertOrIgnore([
            'parent_id' => null,
            'key' => 'atolliva-maldives',
            'label' => 'Atolliva Maldives',
            'route_name' => 'atolliva',
            'url' => null,
            'active_route_pattern' => 'atolliva',
            'menu_style' => 'link',
            'menu_heading' => null,
            'sort_order' => 80,
            'show_in_desktop' => true,
            'show_in_mobile' => true,
            'open_in_new_tab' => false,
            'active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        DB::table('navigation_items')->where('key', 'atolliva-maldives')->delete();
    }
};
