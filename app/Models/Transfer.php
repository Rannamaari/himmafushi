<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transfer extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'from_location',
        'to_location',
        'type',
        'departure_time',
        'operating_days',
        'local_price',
        'tourist_price',
        'tourist_currency',
        'duration_minutes',
        'notes',
        'featured',
        'featured_order',
        'featured_from',
        'featured_until',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'departure_time' => 'datetime:H:i',
            'operating_days' => 'array',
            'active' => 'boolean',
            'featured' => 'boolean',
            'featured_from' => 'datetime',
            'featured_until' => 'datetime',
            'local_price' => 'decimal:2',
            'tourist_price' => 'decimal:2',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(TransferBooking::class);
    }

    public function scopeCurrentlyFeatured(Builder $query): Builder
    {
        return $query->where('active', true)->where('featured', true)
            ->where(fn (Builder $dates) => $dates->whereNull('featured_from')->orWhere('featured_from', '<=', now()))
            ->where(fn (Builder $dates) => $dates->whereNull('featured_until')->orWhere('featured_until', '>=', now()));
    }
}
