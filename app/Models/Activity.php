<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['name', 'category', 'slug', 'short_description', 'description', 'price_from', 'currency', 'local_price', 'tourist_price', 'price_tiers', 'duration_minutes', 'image', 'whatsapp', 'featured', 'featured_order', 'featured_from', 'featured_until', 'active', 'booking_available', 'partner_excursion'];

    protected function casts(): array
    {
        return ['price_from' => 'decimal:2', 'local_price' => 'decimal:2', 'tourist_price' => 'decimal:2', 'price_tiers' => 'array', 'featured' => 'boolean', 'featured_from' => 'datetime', 'featured_until' => 'datetime', 'active' => 'boolean', 'booking_available' => 'boolean', 'partner_excursion' => 'boolean'];
    }

    public function priceForParticipants(int $participants): ?float
    {
        $tiers = $this->price_tiers ?? [];
        $label = match (true) {
            $participants <= 1 => '1 person', $participants === 2 => '2 people', $participants === 3 => '3 people', $participants === 4 => '4 people', default => '5+ people'
        };
        $price = collect($tiers)->first(fn (array $tier): bool => ($tier['label'] ?? null) === $label)['amount'] ?? null;

        if (is_numeric($price)) {
            return (float) $price;
        }

        return $tiers ? null : ($this->price_from !== null ? (float) $this->price_from : null);
    }

    public function scopeCurrentlyFeatured(Builder $query): Builder
    {
        return $query->where('active', true)->where('featured', true)
            ->where(fn (Builder $dates) => $dates->whereNull('featured_from')->orWhere('featured_from', '<=', now()))
            ->where(fn (Builder $dates) => $dates->whereNull('featured_until')->orWhere('featured_until', '>=', now()));
    }
}
