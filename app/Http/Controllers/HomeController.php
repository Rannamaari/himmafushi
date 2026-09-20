<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Guesthouse;
use App\Models\HomepageFeature;
use App\Models\HomepageSection;
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
            'featuredItems' => HomepageFeature::live()->orderBy('sort_order')->limit(7)->get(),
            'featuredSection' => HomepageSection::query()->where('key', 'featured')->where('active', true)->first(),
            'articles' => Article::published()->latest('published_at')->limit(3)->get(),
        ]);
    }
}
