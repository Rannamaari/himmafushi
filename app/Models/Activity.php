<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['name', 'slug', 'short_description', 'description', 'price_from', 'currency', 'local_price', 'tourist_price', 'duration_minutes', 'image', 'whatsapp', 'featured', 'featured_order', 'featured_from', 'featured_until', 'active', 'booking_available'];

    protected function casts(): array
    {
        return ['price_from' => 'decimal:2', 'local_price' => 'decimal:2', 'tourist_price' => 'decimal:2', 'featured' => 'boolean', 'featured_from' => 'datetime', 'featured_until' => 'datetime', 'active' => 'boolean', 'booking_available' => 'boolean'];
    }

    public function scopeCurrentlyFeatured(Builder $query): Builder
    {
        return $query->where('active', true)->where('featured', true)
            ->where(fn (Builder $dates) => $dates->whereNull('featured_from')->orWhere('featured_from', '<=', now()))
            ->where(fn (Builder $dates) => $dates->whereNull('featured_until')->orWhere('featured_until', '>=', now()));
    }
}
