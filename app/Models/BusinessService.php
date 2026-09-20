<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessService extends Model
{
    protected $fillable = ['business_id', 'name', 'description', 'price', 'currency', 'duration_minutes', 'available', 'sort_order'];

    protected function casts(): array
    {
        return ['price' => 'decimal:2', 'available' => 'boolean'];
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
