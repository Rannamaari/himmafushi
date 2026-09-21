<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $routes = [
            'surfing' => 'surfing',
            'diving' => 'diving',
            'snorkelling' => 'snorkelling',
            'fishing' => 'fishing-trips',
            'excursions' => 'excursions',
            'sandbank-trips' => 'sandbank-trips',
            'dolphin-cruises' => 'dolphin-cruises',
            'island-life' => 'island-life',
        ];

        foreach ($routes as $key => $routeName) {
            DB::table('navigation_items')->where('key', $key)->update([
                'route_name' => $routeName,
                'url' => null,
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('navigation_items')->whereIn('key', [
            'surfing', 'diving', 'snorkelling', 'fishing', 'excursions',
            'sandbank-trips', 'dolphin-cruises', 'island-life',
        ])->update(['route_name' => 'activities.index', 'updated_at' => now()]);
    }
};
