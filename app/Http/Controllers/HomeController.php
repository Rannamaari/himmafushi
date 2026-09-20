<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Article;
use App\Models\Business;
use App\Models\Deal;
use App\Models\Guesthouse;
use App\Models\Transfer;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function __invoke()
    {
        $guesthouses = Guesthouse::currentlyFeatured()->get()
            ->groupBy('featured_priority')
            ->sortKeysDesc()
            ->flatMap(fn (Collection $group) => $group->sortBy(
                fn (Guesthouse $guesthouse) => hash('sha256', now()->toDateString().'-'.$guesthouse->id),
            ))
            ->take(6)
            ->values();

        return view('home', [
            'transfers' => Transfer::query()->where('active', true)->orderBy('departure_time')->limit(4)->get(),
            'guesthouses' => $guesthouses,
            'featuredItems' => $this->featuredItems(),
            'articles' => Article::published()->latest('published_at')->limit(3)->get(),
        ]);
    }

    private function featuredItems(): Collection
    {
        $activities = Activity::currentlyFeatured()->orderByDesc('featured_order')->get()->map(fn (Activity $item) => [
            'title' => $item->name, 'type' => 'Experience', 'summary' => $item->short_description, 'image' => $item->image,
            'price' => $item->price_from ? trim(($item->currency ?: 'USD').' '.number_format($item->price_from, 0)) : null,
            'badge' => 'Featured', 'url' => route('activities.index'), 'cta' => $item->booking_available ? 'Book' : 'Explore', 'order' => $item->featured_order,
        ]);

        $businesses = Business::currentlyFeatured()->with('category')->orderByDesc('featured_order')->get()->map(fn (Business $item) => [
            'title' => $item->name, 'type' => $item->category->name, 'summary' => $item->short_description, 'image' => $item->image,
            'price' => $item->price_range, 'badge' => 'Popular', 'url' => $this->businessUrl($item), 'cta' => 'View', 'order' => $item->featured_order,
        ]);

        $deals = Deal::currentlyFeatured()->with(['business.category', 'guesthouse'])->orderByDesc('featured_order')->get()->map(fn (Deal $item) => [
            'title' => $item->title, 'type' => 'Special offer', 'summary' => $item->description,
            'image' => $item->business?->image ?: $item->guesthouse?->image,
            'price' => $item->deal_price ? trim(($item->currency ?: 'USD').' '.number_format($item->deal_price, 0)) : null,
            'badge' => 'Special', 'url' => $item->guesthouse ? route('guesthouses.show', $item->guesthouse) : ($item->business ? $this->businessUrl($item->business) : route('deals.index')), 'cta' => 'View', 'order' => $item->featured_order,
        ]);

        $transfers = Transfer::currentlyFeatured()->orderByDesc('featured_order')->get()->map(fn (Transfer $item) => [
            'title' => $item->name, 'type' => 'Transfer', 'summary' => $item->from_location.' to '.$item->to_location,
            'image' => null, 'price' => $item->tourist_price ? $item->tourist_currency.' '.number_format($item->tourist_price, 0) : null,
            'badge' => 'Featured', 'url' => route('transfers.book', $item), 'cta' => 'Book', 'order' => $item->featured_order,
        ]);

        return $activities->concat($businesses)->concat($deals)->concat($transfers)->sortByDesc('order')->values();
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
