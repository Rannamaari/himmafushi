<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Article;
use App\Models\Business;
use App\Models\Deal;
use App\Models\Guesthouse;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $search = trim((string) $request->string('q'));

        return view('search.index', [
            'search' => $search,
            'results' => $search === '' ? collect() : $this->resultsFor($search),
        ]);
    }

    private function resultsFor(string $search): Collection
    {
        $matches = fn ($query, array $columns) => $query->where(function ($nested) use ($columns, $search) {
            foreach ($columns as $column) {
                $nested->orWhere($column, 'like', "%{$search}%");
            }
        });

        $guesthouses = $matches(Guesthouse::query()->where('active', true), ['name', 'description', 'address'])
            ->get()
            ->map(fn (Guesthouse $guesthouse) => $this->result('Stay', 1, $guesthouse->name, $guesthouse->description ?: $guesthouse->address ?: 'Island accommodation in Himmafushi.', route('guesthouses.show', $guesthouse)));

        $businesses = $matches(Business::public()->with('category'), ['name', 'short_description', 'description', 'address'])
            ->get()
            ->map(fn (Business $business) => $this->result($business->category->name, 2, $business->name, $business->short_description ?: $business->description ?: $business->address ?: 'A local Himmafushi business.', $this->businessUrl($business)));

        $activities = $matches(Activity::query()->where('active', true), ['name', 'short_description', 'description'])
            ->get()
            ->map(fn (Activity $activity) => $this->result('Things to do', 3, $activity->name, $activity->short_description ?: $activity->description ?: 'Island experience in Himmafushi.', route('activities.index')));

        $transfers = $matches(Transfer::query()->where('active', true), ['name', 'from_location', 'to_location', 'notes'])
            ->get()
            ->map(fn (Transfer $transfer) => $this->result('Transfer', 4, $transfer->name, trim($transfer->from_location.' to '.$transfer->to_location).($transfer->notes ? ' - '.$transfer->notes : ''), route('transfers.book', $transfer)));

        $deals = $matches(Deal::query()->where('active', true)->with(['business.category', 'guesthouse']), ['title', 'description'])
            ->get()
            ->map(fn (Deal $deal) => $this->result('Deal', 5, $deal->title, $deal->description ?: 'Current Himmafushi offer.', $deal->guesthouse ? route('guesthouses.show', $deal->guesthouse) : ($deal->business ? $this->businessUrl($deal->business) : route('deals.index'))));

        $articles = $matches(Article::published(), ['title', 'excerpt', 'body'])
            ->get()
            ->map(fn (Article $article) => $this->result('News', 6, $article->title, $article->excerpt, route('news.show', $article)));

        return $guesthouses
            ->concat($businesses)
            ->concat($activities)
            ->concat($transfers)
            ->concat($deals)
            ->concat($articles)
            ->sortBy(fn (array $result) => sprintf('%02d-%s', $result['order'], (string) str($result['title'])->lower()))
            ->values();
    }

    private function result(string $type, int $order, string $title, string $summary, string $url): array
    {
        return compact('type', 'order', 'title', 'summary', 'url');
    }

    private function businessUrl(Business $business): string
    {
        $route = match ($business->category->slug) {
            'restaurant' => 'restaurants.show',
            'shop' => 'shops.show',
            'wellness' => 'wellness.show',
            'barber' => 'barbers.show',
            default => null,
        };

        return $route ? route($route, $business) : route('activities.index');
    }
}
