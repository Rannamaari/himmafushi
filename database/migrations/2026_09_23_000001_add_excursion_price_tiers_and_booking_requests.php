<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->json('price_tiers')->nullable()->after('tourist_price');
            $table->string('category')->nullable()->after('name')->index();
            $table->boolean('partner_excursion')->default(false)->after('booking_available')->index();
        });

        Schema::create('activity_booking_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable()->unique();
            $table->foreignId('activity_id')->nullable()->constrained()->nullOnDelete();
            $table->string('activity_name');
            $table->date('preferred_date');
            $table->unsignedSmallInteger('participants')->default(1);
            $table->string('name');
            $table->string('whatsapp', 40);
            $table->string('nationality', 100)->nullable();
            $table->text('notes')->nullable();
            $table->decimal('estimated_total', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->string('status')->default('new')->index();
            $table->timestamps();
        });

        $now = now();
        DB::table('site_settings')->insertOrIgnore([
            'key' => 'telegram_excursion_chat_id', 'label' => 'Excursion booking chat ID', 'group' => 'Telegram',
            'value' => null, 'secret_value' => null, 'is_secret' => false, 'active' => false,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        DB::table('activities')->insertOrIgnore([
            [
                'name' => 'Surf to Jails, Sultans & Honkeys', 'category' => 'Surfing', 'slug' => 'surf-jails-sultans-honkeys',
                'short_description' => 'Boat trip to North Male Atoll’s iconic surf breaks.',
                'description' => 'Advance-book a surf trip to Jails, Sultans and Honkeys with the local Ocean Monkey Himmafushi team. Conditions, surf access and departure timing are confirmed with the operator.',
                'price_from' => 15, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '3 people', 'amount' => 25], ['label' => '5+ people', 'amount' => 15],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Surf to Ninjas', 'category' => 'Surfing', 'slug' => 'surf-to-ninjas',
                'short_description' => 'Surf boat session at Ninjas, with group rates.',
                'description' => 'Request an advance booking for a surf trip to Ninjas through Ocean Monkey Himmafushi. Final schedule and conditions depend on the day’s surf and operator availability.',
                'price_from' => 25, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 90], ['label' => '2 people', 'amount' => 45], ['label' => '3 people', 'amount' => 30], ['label' => '5+ people', 'amount' => 25],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Surf to Cokes & Chickens', 'category' => 'Surfing', 'slug' => 'surf-cokes-chickens',
                'short_description' => 'Boat trip to Cokes and Chickens surf breaks.',
                'description' => 'Plan a surf boat trip to Cokes and Chickens. Book ahead through us and the Ocean Monkey team will confirm conditions and the available departure.',
                'price_from' => 35, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 130], ['label' => '2 people', 'amount' => 65], ['label' => '3 people', 'amount' => 45], ['label' => '5+ people', 'amount' => 35],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Snorkelling at Ray Point', 'category' => 'Snorkelling', 'slug' => 'snorkelling-ray-point',
                'short_description' => 'Snorkel with rays at a local reef point.',
                'description' => 'Join a guided snorkelling trip to Ray Point. Sightings vary with wildlife and sea conditions and cannot be guaranteed.',
                'price_from' => 20, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 80], ['label' => '2 people', 'amount' => 40], ['label' => '3 people', 'amount' => 25], ['label' => '5+ people', 'amount' => 20],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Snorkelling with Nurse Sharks', 'category' => 'Snorkelling', 'slug' => 'snorkelling-nurse-sharks',
                'short_description' => 'Guided boat trip to observe nurse sharks.',
                'description' => 'Book a guided nurse shark snorkelling trip. Wildlife is unpredictable; follow the operator’s safety briefing and instructions throughout the trip.',
                'price_from' => 80, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 280], ['label' => '2 people', 'amount' => 140], ['label' => '3 people', 'amount' => 95], ['label' => '5+ people', 'amount' => 80],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Dolphin Watching', 'category' => 'Cruises', 'slug' => 'dolphin-watching',
                'short_description' => 'Cruise the atoll in search of dolphins.',
                'description' => 'A scenic dolphin-watching cruise with a local boat operator. Dolphin sightings are not guaranteed.',
                'price_from' => 40, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 150], ['label' => '2 people', 'amount' => 75], ['label' => '3 people', 'amount' => 50], ['label' => '5+ people', 'amount' => 40],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Sunset Fishing', 'category' => 'Fishing', 'slug' => 'sunset-fishing',
                'short_description' => 'A sunset fishing trip with tackle and bait included.',
                'description' => 'Head out for sunset fishing with fishing materials and bait included, as shown on the Ocean Monkey price list. Ask us to confirm the trip time and sea conditions.',
                'price_from' => 40, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 150], ['label' => '2 people', 'amount' => 75], ['label' => '3 people', 'amount' => 50], ['label' => '5+ people', 'amount' => 40],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Snorkel Turtle Point', 'category' => 'Snorkelling', 'slug' => 'snorkel-turtle-point',
                'short_description' => 'Snorkel a turtle point with a local guide.',
                'description' => 'A guided snorkelling outing to a turtle point. Turtle sightings depend on natural conditions and cannot be guaranteed.',
                'price_from' => 25, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 85], ['label' => '2 people', 'amount' => 40], ['label' => '3 people', 'amount' => 30], ['label' => '5+ people', 'amount' => 25],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Turtle Point & Alternative Snorkel Point', 'category' => 'Snorkelling', 'slug' => 'turtle-point-alternative-snorkel',
                'short_description' => 'Two snorkelling locations in one outing.',
                'description' => 'Combine Turtle Point with a different snorkelling point in one boat trip. Stops depend on weather and operator advice.',
                'price_from' => 45, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 180], ['label' => '2 people', 'amount' => 90], ['label' => '3 people', 'amount' => 60], ['label' => '5+ people', 'amount' => 45],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Snorkel Coral Garden', 'category' => 'Snorkelling', 'slug' => 'snorkel-coral-garden',
                'short_description' => 'Explore a coral garden with a local boat guide.',
                'description' => 'A guided snorkelling visit to Coral Garden. Site selection can change with weather and water conditions.',
                'price_from' => 25, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 100], ['label' => '2 people', 'amount' => 50], ['label' => '3 people', 'amount' => 35], ['label' => '5+ people', 'amount' => 25],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Island Hopping: Huraa', 'category' => 'Island Hopping', 'slug' => 'island-hopping-huraa',
                'short_description' => 'Boat trip to Huraa island.',
                'description' => 'Explore Huraa on a local island-hopping trip. Confirm the itinerary and time ashore with us when booking.',
                'price_from' => 25, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 85], ['label' => '2 people', 'amount' => 45], ['label' => '3 people', 'amount' => 30], ['label' => '5+ people', 'amount' => 25],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Island Hopping: Thulusdhoo', 'category' => 'Island Hopping', 'slug' => 'island-hopping-thulusdhoo',
                'short_description' => 'Visit nearby Thulusdhoo by boat.',
                'description' => 'Arrange a visit to Thulusdhoo by boat. The operator will confirm the route, timing and available time on the island.',
                'price_from' => 40, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 150], ['label' => '2 people', 'amount' => 75], ['label' => '3 people', 'amount' => 50], ['label' => '5+ people', 'amount' => 40],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Nurse Shark & Sandbank Package', 'category' => 'Packages', 'slug' => 'nurse-shark-sandbank-package',
                'short_description' => 'Nurse shark snorkelling, sandbank visit, lunch and drinks.',
                'description' => 'A combined day package including nurse shark snorkelling, a sandbank visit, lunch, juice and water, according to the supplied Ocean Monkey price list. Confirm inclusions and schedule before booking.',
                'price_from' => 85, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 350], ['label' => '2 people', 'amount' => 175], ['label' => '3 people', 'amount' => 120], ['label' => '5+ people', 'amount' => 85],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'Two Snorkel Points & Sandbank Package', 'category' => 'Packages', 'slug' => 'two-snorkel-points-sandbank-package',
                'short_description' => 'Two snorkel points, a sandbank, and lunch.',
                'description' => 'Visit two snorkelling locations and a sandbank, with lunch included as shown on the supplied Ocean Monkey price list. Ask us to confirm the itinerary and inclusions for your date.',
                'price_from' => 85, 'currency' => 'USD', 'price_tiers' => json_encode([
                    ['label' => '1 person', 'amount' => 325], ['label' => '2 people', 'amount' => 160], ['label' => '3 people', 'amount' => 110], ['label' => '5+ people', 'amount' => 85],
                ]),
                'image' => null, 'featured' => true, 'active' => true, 'booking_available' => true, 'partner_excursion' => true, 'created_at' => $now, 'updated_at' => $now,
            ],
        ]);

        foreach ([
            'surf-jails-sultans-honkeys', 'surf-to-ninjas', 'surf-cokes-chickens', 'snorkelling-ray-point',
            'snorkelling-nurse-sharks', 'dolphin-watching', 'sunset-fishing', 'snorkel-turtle-point',
            'turtle-point-alternative-snorkel', 'snorkel-coral-garden', 'island-hopping-huraa',
            'island-hopping-thulusdhoo', 'nurse-shark-sandbank-package', 'two-snorkel-points-sandbank-package',
        ] as $order => $slug) {
            DB::table('activities')->where('slug', $slug)->update(['featured_order' => (14 - $order) * 10]);
        }
    }

    public function down(): void
    {
        DB::table('site_settings')->where('key', 'telegram_excursion_chat_id')->delete();
        Schema::dropIfExists('activity_booking_requests');
        Schema::table('activities', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['partner_excursion']);
            $table->dropColumn(['price_tiers', 'category', 'partner_excursion']);
        });
    }
};
