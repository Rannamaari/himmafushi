<?php

namespace Database\Seeders;

use App\Models\NavigationItem;
use Illuminate\Database\Seeder;

class NavigationItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['stay', 'Stay', 'guesthouses.index', 'guesthouses.*', 'dropdown', 'Stay in Himmafushi', 10, true],
            ['eat', 'Eat & Drink', 'restaurants.index', 'restaurants.*', 'link', null, 20, true],
            ['transfers', 'Transfers', 'transfers.index', 'transfers.*', 'dropdown', 'Travel made simple', 30, true],
            ['things-to-do', 'Things To Do', 'activities.index', 'activities.*', 'mega', 'Explore Himmafushi', 40, true],
            ['shops', 'Shops', 'shops.index', 'shops.*', 'link', null, 50, true],
            ['wellness', 'Wellness', 'wellness.index', 'wellness.*', 'link', null, 60, true],
            ['deals', 'Deals', 'deals.index', 'deals.*', 'link', null, 70, true],
            ['news', 'News', 'news.index', 'news.*', 'link', null, 80, false],
        ];

        foreach ($items as [$key, $label, $route, $pattern, $style, $heading, $order, $desktop]) {
            NavigationItem::updateOrCreate(['key' => $key], [
                'label' => $label, 'route_name' => $route, 'active_route_pattern' => $pattern,
                'menu_style' => $style, 'menu_heading' => $heading, 'sort_order' => $order,
                'show_in_desktop' => $desktop, 'show_in_mobile' => true, 'active' => true,
            ]);
        }

        $children = [
            'stay' => [['guest-houses', 'Guest Houses'], ['hotels', 'Hotels'], ['surf-camps', 'Surf Camps']],
            'transfers' => [['airport-transfers', 'Airport Transfers'], ['speedboat-schedule', 'Speedboat Schedule'], ['private-transfers', 'Private Transfers', 'private-transfers']],
            'things-to-do' => [
                ['surfing', 'Surfing', 'surfing'], ['diving', 'Diving', 'diving'],
                ['snorkelling', 'Snorkelling', 'snorkelling'], ['fishing', 'Fishing', 'fishing-trips'],
                ['excursions', 'Excursions', 'excursions'], ['sandbank-trips', 'Sandbank Trips', 'sandbank-trips'],
                ['dolphin-cruises', 'Dolphin Cruises', 'dolphin-cruises'], ['island-life', 'Island Life', 'island-life'],
            ],
        ];

        foreach ($children as $parentKey => $links) {
            $parent = NavigationItem::where('key', $parentKey)->firstOrFail();
            foreach ($links as $index => $link) {
                [$key, $label, $route] = [...$link, $parent->route_name];
                NavigationItem::updateOrCreate(['key' => $key], [
                    'parent_id' => $parent->id, 'label' => $label, 'route_name' => $route,
                    'sort_order' => ($index + 1) * 10, 'menu_style' => 'link', 'active' => true,
                ]);
            }
        }
    }
}
