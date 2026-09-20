<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Deal;
use App\Models\Guesthouse;
use Illuminate\Database\Seeder;

class HimmafushiDirectorySeeder extends Seeder
{
    public function run(): void
    {
        $guesthouses = [
            ['name' => "Bito's Guest House", 'slug' => 'bitos-guest-house', 'address' => 'RoashanyAage, Himmafushi 08060, Maldives', 'phone' => '+9607779615', 'email' => 'reservations.bitos@gmail.com', 'image' => 'demos/guesthouse-demo.png', 'featured' => true],
            ['name' => 'Keveli Guesthouse', 'slug' => 'keveli-guesthouse', 'address' => 'Keveli, Bodukaashi Magu, Himmafushi 08060, Maldives', 'phone' => '+9609356162', 'email' => 'contact@kevelighmaldives.com', 'image' => 'demos/guesthouse-demo.png', 'featured' => true],
            ['name' => 'Himmafushi Inn', 'slug' => 'himmafushi-inn', 'address' => 'Hedheykuri, Bodu Kashi Magu, Himmafushi', 'phone' => '+9607681479', 'email' => 'himmafushi.inn@gmail.com', 'image' => 'demos/guesthouse-demo.png'],
            ['name' => 'Himmafushi Surfing Home', 'slug' => 'himmafushi-surfing-home', 'address' => 'Blowing Rooshan, Himmafushi', 'phone' => '+9607225655', 'email' => 'himmafushi-surfing-home@gmail.com', 'image' => 'demos/guesthouse-demo.png'],
            ['name' => 'Noah Private Beach House', 'slug' => 'noah-private-beach-house', 'address' => 'Himmafushi Island, Maldives', 'image' => 'demos/guesthouse-demo.png', 'featured' => true],
            ['name' => 'Wave By FAZIMS', 'slug' => 'wave-by-fazims', 'description' => 'Guesthouse with a garden and terrace, free WiFi, air-conditioned rooms and breakfast options. Himmafushi Beach is a short walk away.', 'address' => 'Destination, Himmafushi 08060, Maldives', 'image' => 'demos/guesthouse-demo.png', 'featured' => true],
            ['name' => 'FUNPLACE BEACH', 'slug' => 'funplace-beach', 'address' => 'Roazee Magu, Himmafushi'],
            ['name' => 'Maavaharu Guest House Himmafushi', 'slug' => 'maavaharu-guest-house', 'address' => 'Himmafushi, Maldives'],
            ['name' => 'Grande Maldives Inn', 'slug' => 'grande-maldives-inn', 'address' => 'Himmafushi, Maldives'],
            ['name' => 'Moodhu Surf House', 'slug' => 'moodhu-surf-house', 'address' => 'Himmafushi, Maldives'],
            ['name' => 'Aria Holiday Maldives', 'slug' => 'aria-holiday-maldives', 'address' => 'Himmafushi, Maldives'],
            ['name' => 'Jail Break Surf Inn', 'slug' => 'jail-break-surf-inn', 'address' => 'Himmafushi, Maldives'],
            ['name' => 'Vilu Himmafushi', 'slug' => 'vilu-himmafushi', 'address' => 'Himmafushi, Maldives'],
            ['name' => 'GK Eleven', 'slug' => 'gk-eleven', 'address' => 'Himmafushi, Maldives'],
            ['name' => 'Oya Maldives', 'slug' => 'oya-maldives', 'address' => 'Himmafushi, Maldives'],
            ['name' => 'Cocomo Maldives', 'slug' => 'cocomo-maldives', 'address' => 'Himmafushi, Maldives'],
            ['name' => 'Aloha Beach Inn', 'slug' => 'aloha-beach-inn', 'address' => 'Himmafushi, Maldives'],
            ['name' => 'Bahaaru Villa Surf and Stay', 'slug' => 'bahaaru-villa-surf-and-stay', 'address' => 'Himmafushi, Maldives'],
            ['name' => 'Molar Wave', 'slug' => 'molar-wave', 'address' => 'Himmafushi, Maldives'],
            ['name' => 'YUVi Blue Maldives', 'slug' => 'yuvi-blue-maldives', 'address' => 'Himmafushi, Maldives'],
        ];

        foreach ($guesthouses as $guesthouse) {
            Guesthouse::query()->updateOrCreate(['slug' => $guesthouse['slug']], $guesthouse + ['active' => true, 'featured' => false]);
        }

        $waveByFazims = Guesthouse::query()->where('slug', 'wave-by-fazims')->firstOrFail();
        Deal::query()->updateOrCreate(['slug' => 'wave-by-fazims-deal-with-us'], [
            'guesthouse_id' => $waveByFazims->id,
            'title' => 'Deal with us at Wave By FAZIMS',
            'slug' => 'wave-by-fazims-deal-with-us',
            'description' => 'Request a direct stay offer through Himmafushi. Availability and the final rate are confirmed by Wave By FAZIMS.',
            'customer_type' => 'all',
            'featured' => true,
            'active' => true,
        ]);

        $categories = [];
        foreach ([
            ['name' => 'Restaurant', 'slug' => 'restaurant'],
            ['name' => 'Shop', 'slug' => 'shop'],
            ['name' => 'Dive Centre', 'slug' => 'dive-centre'],
            ['name' => 'Surf Shop', 'slug' => 'surf-shop'],
        ] as $category) {
            $categories[$category['slug']] = BusinessCategory::query()->updateOrCreate(['slug' => $category['slug']], $category + ['active' => true]);
        }

        $businesses = [
            ['category' => 'restaurant', 'name' => 'Aandhogey Cafe & Bistro', 'slug' => 'aandhogey-cafe-bistro', 'address' => 'Himmafushi 08060, Maldives', 'phone' => '+9609987771', 'whatsapp' => '+9609987771', 'image' => 'demos/restaurant-demo.png', 'featured' => true, 'dine_in_available' => true],
            ['category' => 'restaurant', 'name' => 'Moscow Yeda', 'slug' => 'moscow-yeda', 'short_description' => 'Local restaurant in Himmafushi.', 'address' => 'Himmafushi 08060, Maldives', 'opening_time' => '06:00', 'closing_time' => '00:00', 'image' => 'demos/restaurant-demo.png', 'featured' => true, 'dine_in_available' => true],
            ['category' => 'shop', 'name' => 'Mango Shop Maldives', 'slug' => 'mango-shop-maldives', 'address' => 'K. Himmafushi, Himmafushi 08060, Maldives', 'phone' => '+9607776604', 'whatsapp' => '+9607776604', 'image' => 'demos/shop-demo.png', 'featured' => true],
            ['category' => 'shop', 'name' => 'Happy Market', 'slug' => 'happy-market-himmafushi', 'address' => 'K. Himmafushi, Maldives', 'image' => 'demos/shop-demo.png'],
            ['category' => 'shop', 'name' => 'Moscow Traders', 'slug' => 'moscow-traders', 'short_description' => 'Local groceries, snacks and travel essentials.', 'address' => 'Himmafushi, Maldives', 'image' => 'demos/shop-demo.png', 'featured' => true],
            ['category' => 'shop', 'name' => 'Moscow Mart', 'slug' => 'moscow-mart', 'address' => 'Valu Magu, K. Himmafushi, Maldives', 'image' => 'demos/shop-demo.png'],
            ['category' => 'shop', 'name' => 'Moscow Rynoc', 'slug' => 'moscow-rynoc', 'address' => 'Himmafushi, Maldives', 'image' => 'demos/shop-demo.png'],
            ['category' => 'dive-centre', 'name' => 'Himmafushi Scuba Adventure', 'slug' => 'himmafushi-scuba-adventure', 'address' => 'Plot No. 61, Falas, Bodukaashi Magu, K. Himmafushi 08060, Maldives', 'phone' => '+9609906160', 'email' => 'contact@himmafushiscuba.com', 'image' => 'demos/activity-demo.png', 'featured' => true],
        ];

        foreach ($businesses as $business) {
            $category = $categories[$business['category']];
            unset($business['category']);
            Business::query()->updateOrCreate(['slug' => $business['slug']], $business + ['business_category_id' => $category->id, 'active' => true, 'featured' => false, 'delivery_available' => false, 'takeaway_available' => false, 'dine_in_available' => false]);
        }

        Activity::query()->updateOrCreate(['slug' => 'scuba-diving-himmafushi'], [
            'name' => 'Scuba Diving',
            'slug' => 'scuba-diving-himmafushi',
            'short_description' => 'Diving experiences available through local Himmafushi operators.',
            'image' => 'demos/activity-demo.png',
            'featured' => true,
            'active' => true,
            'booking_available' => false,
        ]);
    }
}
