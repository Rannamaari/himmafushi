<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Business;
use App\Models\Guesthouse;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $pages = collect([
            ['url' => route('home'), 'priority' => '1.0', 'frequency' => 'daily'],
            ['url' => route('guesthouses.index'), 'priority' => '0.9', 'frequency' => 'daily'],
            ['url' => route('transfers.index'), 'priority' => '0.9', 'frequency' => 'daily'],
            ['url' => route('restaurants.index'), 'priority' => '0.8', 'frequency' => 'weekly'],
            ['url' => route('activities.index'), 'priority' => '0.8', 'frequency' => 'weekly'],
            ['url' => route('shops.index'), 'priority' => '0.7', 'frequency' => 'weekly'],
            ['url' => route('wellness.index'), 'priority' => '0.7', 'frequency' => 'weekly'],
            ['url' => route('deals.index'), 'priority' => '0.8', 'frequency' => 'daily'],
            ['url' => route('news.index'), 'priority' => '0.8', 'frequency' => 'daily'],
            ['url' => route('packages'), 'priority' => '0.8', 'frequency' => 'weekly'],
            ['url' => route('excursions'), 'priority' => '0.8', 'frequency' => 'weekly'],
            ['url' => route('fishing-trips'), 'priority' => '0.8', 'frequency' => 'weekly'],
            ['url' => route('partner'), 'priority' => '0.6', 'frequency' => 'monthly'],
            ['url' => route('list-guesthouse'), 'priority' => '0.7', 'frequency' => 'monthly'],
            ['url' => route('terms'), 'priority' => '0.3', 'frequency' => 'yearly'],
            ['url' => route('privacy'), 'priority' => '0.3', 'frequency' => 'yearly'],
        ]);

        Guesthouse::query()->where('active', true)->get()->each(fn (Guesthouse $item) => $pages->push([
            'url' => route('guesthouses.show', $item), 'lastmod' => $item->updated_at?->toAtomString(), 'priority' => '0.8', 'frequency' => 'weekly',
        ]));

        Business::public()->with('category')->get()->each(function (Business $item) use ($pages): void {
            $route = match ($item->category?->slug) {
                'restaurant' => 'restaurants.show', 'shop' => 'shops.show', 'wellness' => 'wellness.show', 'barber' => 'barbers.show', default => null,
            };
            if ($route) {
                $pages->push(['url' => route($route, $item), 'lastmod' => $item->updated_at?->toAtomString(), 'priority' => '0.7', 'frequency' => 'weekly']);
            }
        });

        Article::published()->get()->each(fn (Article $item) => $pages->push([
            'url' => route('news.show', $item), 'lastmod' => ($item->updated_at ?: $item->published_at)?->toAtomString(), 'priority' => '0.7', 'frequency' => 'monthly',
        ]));

        return response()->view('sitemap', compact('pages'))->header('Content-Type', 'application/xml');
    }
}
