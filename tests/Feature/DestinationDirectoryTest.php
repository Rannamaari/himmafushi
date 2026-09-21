<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Advertisement;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Deal;
use App\Models\Guesthouse;
use App\Models\HomepageFeature;
use App\Models\NavigationItem;
use App\Models\NewsletterSubscriber;
use App\Models\SiteSetting;
use App\Models\Transfer;
use App\Services\GoogleMapsLocationResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DestinationDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_directory_pages_are_available_without_data(): void
    {
        $this->get('/')->assertOk();
        $this->get('/himmafushi')->assertOk()
            ->assertSee('Himmafushi Island Guide')
            ->assertSee('FAQPage', false);
        $this->get('/restaurants')->assertOk();
        $this->get('/shops')->assertOk();
        $this->get('/wellness')->assertOk();
        $this->get('/barbers')->assertOk();
        $this->get('/guesthouses')->assertOk();
        $this->get('/transfers')->assertOk();
        $this->get('/private-transfers')->assertOk()->assertSee('Call +960 7779493');
    }

    public function test_legal_partnership_and_experience_pages_are_available(): void
    {
        $pages = [
            '/terms', '/privacy', '/partner-with-us', '/list-your-guesthouse',
            '/packages', '/excursions', '/fishing-trips', '/surfing', '/diving',
            '/snorkelling', '/sandbank-trips', '/dolphin-cruises', '/island-life',
        ];

        foreach ($pages as $page) {
            $this->get($page)->assertOk()->assertSee('7779493');
        }

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee(route('packages'), false)
            ->assertSee(route('list-guesthouse'), false);
    }

    public function test_things_to_do_navigation_links_to_dedicated_booking_pages(): void
    {
        $this->seed(\Database\Seeders\NavigationItemSeeder::class);

        $response = $this->get('/');

        foreach (['surfing', 'diving', 'snorkelling', 'fishing-trips', 'excursions', 'sandbank-trips', 'dolphin-cruises', 'island-life'] as $route) {
            $response->assertSee(route($route), false);
        }

        $this->get('/activities')->assertOk()->assertSee('Book Island Experiences');
        $this->get('/surfing')->assertOk()
            ->assertSee('About Jailbreaks')
            ->assertSee('AtollivaMaldives.com')
            ->assertSee('FAQPage', false);
    }

    public function test_private_transfer_navigation_links_to_its_booking_page(): void
    {
        $this->seed(\Database\Seeders\NavigationItemSeeder::class);

        $this->get('/')->assertOk()->assertSee(route('private-transfers'), false);
    }

    public function test_only_active_businesses_are_displayed_publicly(): void
    {
        $category = BusinessCategory::create(['name' => 'Restaurant', 'slug' => 'restaurant']);
        Business::create(['business_category_id' => $category->id, 'name' => 'Visible Cafe', 'slug' => 'visible-cafe', 'active' => true]);
        Business::create(['business_category_id' => $category->id, 'name' => 'Hidden Cafe', 'slug' => 'hidden-cafe', 'active' => false]);

        $this->get('/restaurants')->assertOk()->assertSee('Visible Cafe')->assertDontSee('Hidden Cafe');
    }

    public function test_business_detail_route_uses_slug_model_binding(): void
    {
        $category = BusinessCategory::create(['name' => 'Restaurant', 'slug' => 'restaurant']);
        $business = Business::create([
            'business_category_id' => $category->id, 'name' => 'Moscow Yeda', 'slug' => 'moscow-yeda',
            'latitude' => 4.3085000, 'longitude' => 73.5702000, 'google_maps_url' => 'https://maps.google.com/?q=4.3085,73.5702', 'active' => true,
        ]);

        $this->get(route('restaurants.show', $business))->assertOk()->assertSee('Moscow Yeda')->assertSee('Find Moscow Yeda')->assertSee('z=20', false);
    }

    public function test_google_maps_coordinates_can_be_extracted_from_shared_urls(): void
    {
        $coordinates = app(GoogleMapsLocationResolver::class)->extractCoordinates('https://www.google.com/maps/place/Moscow+Yeda/@4.3085,73.5702,20z');

        $this->assertSame(['latitude' => 4.3085, 'longitude' => 73.5702], $coordinates);
    }

    public function test_search_page_returns_matching_guesthouses(): void
    {
        Guesthouse::create(['name' => 'Wave By FAZIMS', 'slug' => 'wave-by-fazims', 'active' => true]);

        $this->get('/search?q=wave')->assertOk()->assertSee('Wave By FAZIMS')->assertSee('Stay');
    }

    public function test_search_page_includes_matching_public_directory_and_news_items(): void
    {
        $category = BusinessCategory::create(['name' => 'Restaurant', 'slug' => 'restaurant']);
        Business::create(['business_category_id' => $category->id, 'name' => 'Island Breakfast', 'slug' => 'island-breakfast', 'short_description' => 'Breakfast near the beach', 'active' => true]);
        Article::create(['title' => 'Breakfast in Himmafushi', 'slug' => 'breakfast-in-himmafushi', 'excerpt' => 'Where to eat breakfast.', 'body' => 'Article body.', 'published_at' => now(), 'active' => true]);

        $this->get('/search?q=Breakfast')->assertOk()->assertSee('Island Breakfast')->assertSee('Breakfast in Himmafushi')->assertSee('Restaurant')->assertSee('News');
    }

    public function test_guesthouse_page_shows_its_current_deals_only(): void
    {
        $guesthouse = Guesthouse::create(['name' => 'Wave By FAZIMS', 'slug' => 'wave-by-fazims', 'active' => true]);
        Deal::create(['guesthouse_id' => $guesthouse->id, 'title' => 'Stay three nights, save 10%', 'slug' => 'wave-stay-three-save-ten', 'description' => 'A direct booking offer.', 'deal_price' => 270, 'currency' => 'USD', 'active' => true]);
        Deal::create(['guesthouse_id' => $guesthouse->id, 'title' => 'Expired offer', 'slug' => 'wave-expired-offer', 'active' => true, 'ends_at' => now()->subDay()]);

        $this->get(route('guesthouses.show', $guesthouse))->assertOk()->assertSee('Stay three nights, save 10%')->assertSee('USD 270')->assertDontSee('Expired offer');
    }

    public function test_homepage_shows_current_featured_content_and_hides_future_advertisements(): void
    {
        Activity::create(['name' => 'Lagoon Snorkeling', 'slug' => 'lagoon-snorkeling', 'short_description' => 'A guided lagoon trip.', 'featured' => true, 'featured_order' => 10, 'active' => true]);
        HomepageFeature::create(['title' => 'Lagoon Snorkeling', 'type_label' => 'Experience', 'summary' => 'A guided lagoon trip.', 'url' => '/activities', 'active' => true]);
        Advertisement::create(['advertiser' => 'Visible Sponsor', 'placement' => 'home_search_sponsor', 'destination_url' => '/shops', 'active' => true]);
        Advertisement::create(['advertiser' => 'Future Sponsor', 'placement' => 'home_after_blog', 'starts_at' => now()->addDay(), 'active' => true]);

        $this->get('/')->assertOk()->assertSee('Featured in Himmafushi')->assertSee('Lagoon Snorkeling')->assertSee('Visible Sponsor')->assertDontSee('Future Sponsor');
    }

    public function test_navigation_and_dropdown_items_are_loaded_from_the_database(): void
    {
        $stay = NavigationItem::create([
            'key' => 'stay', 'label' => 'Custom Stay', 'route_name' => 'guesthouses.index',
            'active_route_pattern' => 'guesthouses.*', 'menu_style' => 'dropdown', 'active' => true,
        ]);
        NavigationItem::create([
            'parent_id' => $stay->id, 'key' => 'surf-camps', 'label' => 'Custom Surf Camps',
            'route_name' => 'guesthouses.index', 'active' => true,
        ]);

        $this->get('/')->assertOk()->assertSee('Custom Stay')->assertSee('Custom Surf Camps');
    }

    public function test_adsense_code_can_be_rendered_globally_and_after_blog_content(): void
    {
        $article = Article::create(['title' => 'Ad test', 'slug' => 'ad-test', 'excerpt' => 'Testing ads.', 'body' => 'Article body.', 'published_at' => now(), 'active' => true]);
        Advertisement::create(['advertiser' => 'Google AdSense', 'placement' => 'site_head', 'embed_code' => '<script data-site-ads="enabled"></script>', 'active' => true]);
        Advertisement::create(['advertiser' => 'Google AdSense', 'placement' => 'blog_after_content', 'embed_code' => '<ins class="adsbygoogle" data-ad-slot="123"></ins>', 'active' => true]);

        $this->get(route('news.show', $article))
            ->assertOk()
            ->assertSee('data-site-ads="enabled"', false)
            ->assertSee('data-ad-slot="123"', false);
    }

    public function test_advertisement_tracking_records_impressions_and_clicks(): void
    {
        $advertisement = Advertisement::create(['advertiser' => 'Island Sponsor', 'placement' => 'home_after_blog', 'destination_url' => '/shops', 'active' => true]);

        $this->post(route('ads.impression', $advertisement))->assertNoContent();
        $this->get(route('ads.click', $advertisement))->assertRedirect('/shops');

        $this->assertDatabaseHas('advertisements', ['id' => $advertisement->id, 'impressions' => 1, 'clicks' => 1]);
    }

    public function test_published_news_and_consented_newsletter_signups_are_publicly_available(): void
    {
        $article = Article::create(['title' => 'Island update', 'slug' => 'island-update', 'excerpt' => 'A useful update.', 'body' => 'News body.', 'published_at' => now(), 'active' => true]);

        $this->get('/news')->assertOk()->assertSee('Island update');
        $this->get(route('news.show', $article))->assertOk()->assertSee('News body.');
        $this->post('/newsletter-subscriptions', ['email' => 'guest@example.com', 'accept_terms' => true])->assertSessionHas('newsletter_success');
        $this->assertDatabaseHas('newsletter_subscribers', ['email' => 'guest@example.com', 'status' => 'active']);
        $this->assertSame(1, NewsletterSubscriber::count());
    }

    public function test_new_newsletter_signup_sends_one_telegram_notification(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true])]);
        SiteSetting::where('key', 'telegram_bot_token')->update(['secret_value' => '123456:test-token', 'active' => true]);
        SiteSetting::where('key', 'telegram_newsletter_chat_id')->update(['value' => '-100123456', 'active' => true]);

        $signup = ['email' => 'offers@example.com', 'accept_terms' => true];
        $this->post('/newsletter-subscriptions', $signup)->assertSessionHas('newsletter_success');
        $this->post('/newsletter-subscriptions', $signup)->assertSessionHas('newsletter_success');

        Http::assertSentCount(1);
        Http::assertSent(fn ($request): bool => $request['chat_id'] === '-100123456'
            && str_contains($request['text'], 'offers@example.com'));
    }

    public function test_newsletter_popup_is_available_sitewide(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('data-newsletter-popup', false)
            ->assertSee('Get better island deals.');
    }

    public function test_articles_support_categories_rich_content_and_category_filtering(): void
    {
        $guides = ArticleCategory::where('slug', 'island-guides')->firstOrFail();
        $news = ArticleCategory::where('slug', 'local-news')->firstOrFail();
        Article::create(['article_category_id' => $guides->id, 'title' => 'Reef Guide', 'slug' => 'reef-guide', 'excerpt' => 'A reef guide.', 'body' => '<h2>Protect the reef</h2><p>Travel thoughtfully.</p>', 'published_at' => now(), 'active' => true]);
        Article::create(['article_category_id' => $news->id, 'title' => 'Harbour News', 'slug' => 'harbour-news', 'excerpt' => 'A local update.', 'body' => '<p>Latest update.</p>', 'published_at' => now(), 'active' => true]);

        $this->get('/news?category=island-guides')->assertOk()->assertSee('Reef Guide')->assertDontSee('Harbour News');
        $this->get('/news/reef-guide')->assertOk()->assertSee('<h2>Protect the reef</h2>', false);
    }

    public function test_enabled_google_analytics_setting_is_added_to_public_pages(): void
    {
        SiteSetting::where('key', 'google_analytics_id')->update(['value' => 'G-TEST123', 'active' => true]);

        $this->get('/')->assertOk()->assertSee('googletagmanager.com/gtag/js?id=G-TEST123', false);
    }

    public function test_integration_settings_store_telegram_tokens_encrypted(): void
    {
        $setting = SiteSetting::where('key', 'telegram_bot_token')->firstOrFail();
        $setting->update(['secret_value' => '123456:secret-token', 'active' => true]);

        $this->assertSame('123456:secret-token', SiteSetting::configuredValue('telegram_bot_token'));
        $this->assertNotSame('123456:secret-token', \DB::table('site_settings')->where('key', 'telegram_bot_token')->value('secret_value'));
    }

    public function test_public_pages_include_social_and_structured_seo_metadata(): void
    {
        $this->get('/')->assertOk()
            ->assertSee('rel="icon"', false)
            ->assertSee('property="og:image"', false)
            ->assertSee('name="twitter:card" content="summary_large_image"', false)
            ->assertSee('"@type":"WebSite"', false);

        $this->get('/search?q=stay')->assertOk()->assertSee('name="robots" content="noindex,follow"', false);
    }

    public function test_sitemap_contains_public_directory_and_article_urls(): void
    {
        $article = Article::create(['title' => 'SEO Island Guide', 'slug' => 'seo-island-guide', 'excerpt' => 'A useful guide.', 'body' => '<p>Guide.</p>', 'published_at' => now(), 'active' => true]);
        $guesthouse = Guesthouse::create(['name' => 'Sitemap Stay', 'slug' => 'sitemap-stay', 'active' => true]);

        $this->get('/sitemap.xml')->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('news.show', $article), false)
            ->assertSee(route('guesthouses.show', $guesthouse), false);
    }

    public function test_transfer_and_guesthouse_booking_requests_still_save(): void
    {
        $travelDate = now()->addDay();
        $transfer = Transfer::create(['name' => 'Airport to Himmafushi', 'slug' => 'airport-himmafushi', 'from_location' => 'Airport', 'to_location' => 'Himmafushi', 'operating_days' => [strtolower($travelDate->englishDayOfWeek)]]);
        $guesthouse = Guesthouse::create(['name' => 'Island Stay', 'slug' => 'island-stay']);

        $this->post('/transfer-bookings', ['transfer_id' => $transfer->id, 'customer_type' => 'tourist', 'name' => 'Test Guest', 'whatsapp' => '+9607900000', 'travel_date' => $travelDate->toDateString(), 'passengers' => 2])->assertSessionHas('success');
        $this->post('/guesthouse-bookings', ['guesthouse_id' => $guesthouse->id, 'customer_type' => 'tourist', 'name' => 'Test Guest', 'whatsapp' => '+9607900000', 'check_in' => now()->addDay()->toDateString(), 'check_out' => now()->addDays(2)->toDateString(), 'adults' => 2])->assertSessionHas('success');

        $this->assertDatabaseCount('transfer_bookings', 1);
        $this->assertDatabaseCount('guesthouse_booking_requests', 1);
    }

    public function test_transfer_schedule_filters_departures_by_date_and_records_the_selected_time(): void
    {
        $weekdayTransfer = Transfer::create([
            'name' => 'Schedule Express', 'slug' => 'schedule-express', 'from_location' => 'Male', 'to_location' => 'Himmafushi',
            'departure_time' => '09:45', 'operating_days' => ['monday'], 'tourist_price' => 10, 'local_price' => 100, 'active' => true,
        ]);
        Transfer::create([
            'name' => 'Friday Express', 'slug' => 'friday-express', 'from_location' => 'Male', 'to_location' => 'Himmafushi',
            'departure_time' => '09:00', 'operating_days' => ['friday'], 'active' => true,
        ]);

        $monday = now()->next('monday')->toDateString();
        $this->get('/transfers?date='.$monday)->assertOk()->assertSee('Schedule Express')->assertDontSee('Friday Express');

        $this->post('/transfer-bookings', [
            'transfer_id' => $weekdayTransfer->id, 'customer_type' => 'tourist', 'name' => 'Scheduled Guest',
            'whatsapp' => '+9607900000', 'travel_date' => $monday, 'preferred_time' => '00:00', 'passengers' => 2,
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('transfer_bookings', ['transfer_id' => $weekdayTransfer->id, 'preferred_time' => '09:45', 'passengers' => 2, 'infants' => 0, 'quote_amount' => 20, 'quote_currency' => 'USD']);
    }
}
