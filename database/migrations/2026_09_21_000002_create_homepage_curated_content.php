<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('cta_url', 2048)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('homepage_features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type_label')->nullable();
            $table->text('summary')->nullable();
            $table->string('image')->nullable();
            $table->string('badge')->nullable();
            $table->string('price_text')->nullable();
            $table->string('url', 2048)->nullable();
            $table->string('cta_label')->default('View');
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamp('starts_at')->nullable()->index();
            $table->timestamp('ends_at')->nullable()->index();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
        });

        $now = now();
        DB::table('homepage_sections')->insert([
            'key' => 'featured', 'eyebrow' => 'Curated for your visit', 'title' => 'Featured in Himmafushi',
            'description' => 'Island experiences, local favourites and timely offers worth knowing about.',
            'cta_label' => 'Explore things to do', 'cta_url' => '/activities', 'active' => true,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $order = 10;
        foreach (DB::table('activities')->where('active', true)->where('featured', true)->orderByDesc('featured_order')->limit(7)->get() as $item) {
            DB::table('homepage_features')->insert([
                'title' => $item->name, 'type_label' => 'Experience', 'summary' => $item->short_description,
                'image' => $item->image, 'badge' => 'Featured',
                'price_text' => $item->price_from ? trim(($item->currency ?: 'USD').' '.number_format($item->price_from, 0)) : null,
                'url' => '/activities', 'cta_label' => $item->booking_available ? 'Book' : 'Explore',
                'sort_order' => $order, 'active' => true, 'created_at' => $now, 'updated_at' => $now,
            ]);
            $order += 10;
        }

        $businesses = DB::table('businesses')
            ->join('business_categories', 'business_categories.id', '=', 'businesses.business_category_id')
            ->where('businesses.active', true)->where('businesses.featured', true)
            ->orderByDesc('businesses.featured_order')->limit(max(0, 8 - ($order / 10)))->get([
                'businesses.*', 'business_categories.name as category_name', 'business_categories.slug as category_slug',
            ]);

        foreach ($businesses as $item) {
            $prefix = match ($item->category_slug) {
                'restaurant' => 'restaurants', 'shop' => 'shops', 'wellness' => 'wellness', 'barber' => 'barbers', default => 'activities',
            };
            DB::table('homepage_features')->insert([
                'title' => $item->name, 'type_label' => $item->category_name, 'summary' => $item->short_description,
                'image' => $item->image, 'badge' => 'Popular', 'price_text' => $item->price_range,
                'url' => $prefix === 'activities' ? '/activities' : "/{$prefix}/{$item->slug}", 'cta_label' => 'View',
                'sort_order' => $order, 'active' => true, 'created_at' => $now, 'updated_at' => $now,
            ]);
            $order += 10;
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_features');
        Schema::dropIfExists('homepage_sections');
    }
};
