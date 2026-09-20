<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Business;
use App\Models\Deal;
use App\Models\Guesthouse;
use App\Models\Transfer;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home', [
            'transfers' => Transfer::query()->where('active', true)->orderBy('departure_time')->limit(3)->get(),
            'guesthouses' => Guesthouse::query()->where('active', true)->where('featured', true)->orderBy('name')->limit(3)->get(),
            'restaurants' => Business::public()->inCategory('restaurant')->with('category')->where('featured', true)->limit(3)->get(),
            'activities' => Activity::query()->where('active', true)->where('featured', true)->limit(4)->get(),
            'deals' => Deal::query()->where('active', true)->where(fn ($query) => $query->whereNull('starts_at')->orWhere('starts_at', '<=', now()))->where(fn ($query) => $query->whereNull('ends_at')->orWhere('ends_at', '>=', now()))->with(['business', 'guesthouse'])->limit(3)->get(),
        ]);
    }
}
