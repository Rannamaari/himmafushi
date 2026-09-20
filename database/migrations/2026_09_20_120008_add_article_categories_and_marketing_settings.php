<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('article_category_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->text('value')->nullable();
            $table->boolean('active')->default(false)->index();
            $table->timestamps();
        });

        Schema::table('advertisements', function (Blueprint $table) {
            $table->string('ad_type')->default('banner')->after('placement');
        });

        $now = now();
        DB::table('article_categories')->insert([
            ['name' => 'Island Guides', 'slug' => 'island-guides', 'description' => 'Practical guides for visiting Himmafushi.', 'sort_order' => 10, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Travel Updates', 'slug' => 'travel-updates', 'description' => 'Transfer and travel information.', 'sort_order' => 20, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Local News', 'slug' => 'local-news', 'description' => 'News and stories from Himmafushi.', 'sort_order' => 30, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Offers & Deals', 'slug' => 'offers-deals', 'description' => 'Current island offers and promotions.', 'sort_order' => 40, 'active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('site_settings')->insert([
            ['key' => 'google_analytics_id', 'label' => 'Google Analytics measurement ID', 'value' => null, 'active' => false, 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'google_tag_manager_id', 'label' => 'Google Tag Manager container ID', 'value' => null, 'active' => false, 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'adsense_publisher_id', 'label' => 'Google AdSense publisher ID', 'value' => null, 'active' => false, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $defaultCategory = DB::table('article_categories')->where('slug', 'island-guides')->value('id');
        DB::table('articles')->whereNull('article_category_id')->update(['article_category_id' => $defaultCategory]);
        $travelCategory = DB::table('article_categories')->where('slug', 'travel-updates')->value('id');
        DB::table('articles')->where('slug', 'how-to-plan-your-himmafushi-transfer')->update(['article_category_id' => $travelCategory]);
    }

    public function down(): void
    {
        Schema::table('advertisements', fn (Blueprint $table) => $table->dropColumn('ad_type'));
        Schema::dropIfExists('site_settings');
        Schema::table('articles', fn (Blueprint $table) => $table->dropConstrainedForeignId('article_category_id'));
        Schema::dropIfExists('article_categories');
    }
};
