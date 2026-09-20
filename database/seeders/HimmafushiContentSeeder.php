<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class HimmafushiContentSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'title' => 'A simple first day in Himmafushi',
                'slug' => 'a-simple-first-day-in-himmafushi',
                'excerpt' => 'A calm, practical way to settle in after the speedboat: beach time, local food and a plan for tomorrow.',
                'body' => "Arriving on a local island is best done at an island pace. Once you have checked in, take a short walk to understand the streets, the beach access and the places that are useful for your stay.\n\nKeep your first afternoon simple: eat locally, spend time by the water and ask your host about the next day’s conditions. Himmafushi is compact, so a little orientation goes a long way.\n\nUse our transfer schedule before you travel and save your preferred departure early, especially when you are connecting with a flight.",
                'seo_title' => 'Your First Day in Himmafushi: A Practical Island Guide',
                'seo_description' => 'A practical guide to settling into Himmafushi, from arrival to your first beach walk and local meal.',
                'published_at' => now()->subDays(3),
                'featured' => true,
            ],
            [
                'title' => 'How to plan your Himmafushi transfer',
                'slug' => 'how-to-plan-your-himmafushi-transfer',
                'excerpt' => 'Choose a travel date first, compare the published departure times, and leave enough time around your flight.',
                'body' => "A smooth Himmafushi arrival begins with the transfer schedule. Pick your travel date first because Friday and Saturday-to-Thursday services can differ.\n\nWhen you select a departure, check the route, time and whether you are travelling as a local or tourist. For airport journeys, allow margin for baggage collection and flight changes.\n\nA submitted request lets the booking team confirm the final availability with you before travel.",
                'seo_title' => 'How to Plan a Himmafushi Speedboat Transfer',
                'seo_description' => 'Plan your Himmafushi speedboat transfer with date-first schedules, route checks and flight-time guidance.',
                'published_at' => now()->subDays(2),
                'featured' => false,
            ],
            [
                'title' => 'Visiting Himmafushi with respect',
                'slug' => 'visiting-himmafushi-with-respect',
                'excerpt' => 'A few thoughtful choices help visitors enjoy the island while respecting the people who call it home.',
                'body' => "Himmafushi is a lived-in local island as well as a travel destination. Dress appropriately away from designated beach areas, ask before photographing people and be considerate around homes and prayer times.\n\nSupport local businesses when you can. A meal, a shop visit or a guided activity keeps more of the visitor economy close to the community.\n\nSmall habits matter: carry your waste, refill water where possible and treat the reef and beach with care.",
                'seo_title' => 'Responsible Travel Tips for Himmafushi, Maldives',
                'seo_description' => 'Simple, respectful travel guidance for visitors to Himmafushi, Maldives.',
                'published_at' => now()->subDay(),
                'featured' => false,
            ],
        ] as $article) {
            Article::query()->updateOrCreate(['slug' => $article['slug']], $article + ['active' => true]);
        }
    }
}
