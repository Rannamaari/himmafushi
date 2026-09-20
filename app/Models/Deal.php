<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deal extends Model
{
    protected $fillable = ['business_id', 'guesthouse_id', 'title', 'slug', 'description', 'original_price', 'deal_price', 'currency', 'customer_type', 'starts_at', 'ends_at', 'featured', 'active'];

    protected function casts(): array
    {
        return ['original_price' => 'decimal:2', 'deal_price' => 'decimal:2', 'starts_at' => 'datetime', 'ends_at' => 'datetime', 'featured' => 'boolean', 'active' => 'boolean'];
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
