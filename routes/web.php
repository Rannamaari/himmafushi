<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\ExperiencePageController;
use App\Http\Controllers\GuesthouseBookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TransferBookingController;
use App\Http\Controllers\TransferScheduleController;
use App\Models\Activity;
use App\Models\Deal;
use App\Models\Guesthouse;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::post('/advertisements/{advertisement}/impression', [AdvertisementController::class, 'impression'])->middleware('throttle:60,1')->name('ads.impression');
Route::get('/advertisements/{advertisement}/click', [AdvertisementController::class, 'click'])->middleware('throttle:60,1')->name('ads.click');
Route::get('/search', SearchController::class)->name('search');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{article:slug}', [NewsController::class, 'show'])->name('news.show');
Route::post('/newsletter-subscriptions', [NewsletterSubscriptionController::class, 'store'])->middleware('throttle:5,1')->name('newsletter.subscribe');
Route::view('/terms', 'legal.terms')->name('terms');
Route::view('/privacy', 'legal.privacy')->name('privacy');
Route::view('/himmafushi', 'island-guide')->name('island-guide');
Route::view('/partner-with-us', 'partnerships.partner')->name('partner');
Route::view('/list-your-guesthouse', 'partnerships.list-guesthouse')->name('list-guesthouse');
Route::view('/packages', 'experiences.packages')->name('packages');
Route::view('/excursions', 'experiences.excursions')->name('excursions');
Route::view('/fishing-trips', 'experiences.fishing-trips')->name('fishing-trips');
Route::view('/surfing', 'experiences.surfing')->name('surfing');
Route::get('/diving', ExperiencePageController::class)->defaults('experience', 'diving')->name('diving');
Route::get('/snorkelling', ExperiencePageController::class)->defaults('experience', 'snorkelling')->name('snorkelling');
Route::get('/sandbank-trips', ExperiencePageController::class)->defaults('experience', 'sandbank-trips')->name('sandbank-trips');
Route::get('/dolphin-cruises', ExperiencePageController::class)->defaults('experience', 'dolphin-cruises')->name('dolphin-cruises');
Route::get('/island-life', ExperiencePageController::class)->defaults('experience', 'island-life')->name('island-life');

Route::get('/transfers', [TransferScheduleController::class, 'index'])->name('transfers.index');
Route::view('/private-transfers', 'transfers.private')->name('private-transfers');

Route::get('/transfers/{transfer:slug}/book', [TransferScheduleController::class, 'book'])->name('transfers.book');

Route::post('/transfer-bookings', [TransferBookingController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('transfer-bookings.store');

Route::get('/guesthouses', function () {
    return view('guesthouses.index', [
        'guesthouses' => Guesthouse::query()->where('active', true)->orderByDesc('featured')->orderBy('name')->get(),
    ]);
})->name('guesthouses.index');

Route::get('/guesthouses/{guesthouse:slug}/request', function (Guesthouse $guesthouse) {
    abort_unless($guesthouse->active, 404);

    return view('guesthouses.request', compact('guesthouse'));
})->name('guesthouses.request');

Route::get('/guesthouses/{guesthouse:slug}', function (Guesthouse $guesthouse) {
    abort_unless($guesthouse->active, 404);
    $guesthouse->load(['deals' => fn ($query) => $query
        ->where('active', true)
        ->where(fn ($dates) => $dates->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
        ->where(fn ($dates) => $dates->whereNull('ends_at')->orWhere('ends_at', '>=', now()))
        ->orderByDesc('featured')
        ->latest()]);

    return view('guesthouses.show', compact('guesthouse'));
})->name('guesthouses.show');

Route::post('/guesthouse-bookings', [GuesthouseBookingController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('guesthouse-bookings.store');

Route::get('/restaurants', [DirectoryController::class, 'index'])->defaults('category', 'restaurant')->name('restaurants.index');
Route::get('/restaurants/{business:slug}', [DirectoryController::class, 'show'])->defaults('category', 'restaurant')->name('restaurants.show');
Route::get('/shops', [DirectoryController::class, 'index'])->defaults('category', 'shop')->name('shops.index');
Route::get('/shops/{business:slug}', [DirectoryController::class, 'show'])->defaults('category', 'shop')->name('shops.show');
Route::get('/wellness', [DirectoryController::class, 'index'])->defaults('category', 'wellness')->name('wellness.index');
Route::get('/wellness/{business:slug}', [DirectoryController::class, 'show'])->defaults('category', 'wellness')->name('wellness.show');
Route::get('/barbers', [DirectoryController::class, 'index'])->defaults('category', 'barber')->name('barbers.index');
Route::get('/barbers/{business:slug}', [DirectoryController::class, 'show'])->defaults('category', 'barber')->name('barbers.show');
Route::get('/activities', fn () => view('activities.index', ['activities' => Activity::query()->where('active', true)->orderByDesc('featured')->orderBy('name')->paginate(12)]))->name('activities.index');
Route::get('/deals', fn () => view('deals.index', ['deals' => Deal::query()->where('active', true)->with(['business', 'guesthouse'])->orderByDesc('featured')->latest()->paginate(12)]))->name('deals.index');
