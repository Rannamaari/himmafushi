<?php

namespace App\Models;

use App\Services\GoogleMapsLocationResolver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    protected $fillable = [
        'business_category_id', 'name', 'slug', 'short_description', 'description', 'phone', 'whatsapp', 'email', 'address',
        'opening_time', 'closing_time', 'price_range', 'image', 'cover_image', 'gallery', 'display_priority', 'delivery_available', 'takeaway_available',
        'dine_in_available', 'featured', 'featured_order', 'featured_from', 'featured_until', 'active', 'latitude', 'longitude', 'google_maps_url',
    ];

    protected function casts(): array
    {
        return ['opening_time' => 'datetime:H:i', 'closing_time' => 'datetime:H:i', 'gallery' => 'array', 'display_priority' => 'integer', 'delivery_available' => 'boolean', 'takeaway_available' => 'boolean', 'dine_in_available' => 'boolean', 'featured' => 'boolean', 'featured_from' => 'datetime', 'featured_until' => 'datetime', 'active' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::saving(function (Business $business): void {
            if (! $business->isDirty('google_maps_url') || ! $business->google_maps_url) {
                return;
            }

            $coordinates = app(GoogleMapsLocationResolver::class)->resolve($business->google_maps_url);

            if ($coordinates) {
                $business->latitude = $coordinates['latitude'];
                $business->longitude = $coordinates['longitude'];
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(BusinessService::class);
    }

    public function menuCategories(): HasMany
    {
        return $this->hasMany(RestaurantMenuCategory::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeInCategory(Builder $query, string $slug): Builder
    {
        return $query->whereHas('category', fn (Builder $category) => $category->where('slug', $slug)->where('active', true));
    }

    public function scopeCurrentlyFeatured(Builder $query): Builder
    {
        return $query->public()->where('featured', true)
            ->where(fn (Builder $dates) => $dates->whereNull('featured_from')->orWhere('featured_from', '<=', now()))
            ->where(fn (Builder $dates) => $dates->whereNull('featured_until')->orWhere('featured_until', '>=', now()));
    }

    public function whatsappUrl(string $message = ''): ?string
    {
        if (! $this->whatsapp) {
            return null;
        }
        $number = preg_replace('/\D+/', '', $this->whatsapp);

        return 'https://wa.me/'.$number.($message ? '?text='.rawurlencode($message) : '');
    }
}
