<?php

namespace App\Providers;

use App\Models\NavigationItem;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.site.header', function ($view): void {
            $view->with('navigationItems', NavigationItem::visible()
                ->whereNull('parent_id')
                ->with('children')
                ->get());
        });

        View::composer('components.layouts.app', function ($view): void {
            $view->with('marketingSettings', SiteSetting::query()
                ->where('active', true)
                ->whereNotNull('value')
                ->pluck('value', 'key'));
        });
    }
}
