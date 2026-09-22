<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guesthouse extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'description',
        'address',
        'phone',
        'email',
        'image',
        'gallery',
        'display_priority',
        'local_rate_from',
        'tourist_rate_from',
        'featured',
        'featured_priority',
        'featured_start_at',
        'featured_end_at',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'gallery' => 'array',
            'display_priority' => 'integer',
            'featured_start_at' => 'datetime',
            'featured_end_at' => 'datetime',
            'active' => 'boolean',
            'local_rate_from' => 'decimal:2',
            'tourist_rate_from' => 'decimal:2',
        ];
    }

    public function bookingRequests(): HasMany
    {
        return $this->hasMany(GuesthouseBookingRequest::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function scopeCurrentlyFeatured(Builder $query): Builder
    {
        return $query->where('active', true)->where('featured', true)
            ->where(fn (Builder $dates) => $dates->whereNull('featured_start_at')->orWhere('featured_start_at', '<=', now()))
            ->where(fn (Builder $dates) => $dates->whereNull('featured_end_at')->orWhere('featured_end_at', '>=', now()));
    }
}
