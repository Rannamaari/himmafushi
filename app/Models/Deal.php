<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deal extends Model
{
    protected $fillable = ['business_id', 'guesthouse_id', 'title', 'slug', 'description', 'original_price', 'deal_price', 'currency', 'customer_type', 'starts_at', 'ends_at', 'featured', 'featured_order', 'featured_from', 'featured_until', 'active'];

    protected function casts(): array
    {
        return ['original_price' => 'decimal:2', 'deal_price' => 'decimal:2', 'starts_at' => 'datetime', 'ends_at' => 'datetime', 'featured' => 'boolean', 'featured_from' => 'datetime', 'featured_until' => 'datetime', 'active' => 'boolean'];
    }

    public function scopeCurrentlyFeatured(Builder $query): Builder
    {
        return $query->where('active', true)->where('featured', true)
            ->where(fn (Builder $dates) => $dates->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn (Builder $dates) => $dates->whereNull('ends_at')->orWhere('ends_at', '>=', now()))
            ->where(fn (Builder $dates) => $dates->whereNull('featured_from')->orWhere('featured_from', '<=', now()))
            ->where(fn (Builder $dates) => $dates->whereNull('featured_until')->orWhere('featured_until', '>=', now()));
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function guesthouse(): BelongsTo
    {
        return $this->belongsTo(Guesthouse::class);
    }
}
