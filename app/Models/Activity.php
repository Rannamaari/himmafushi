<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['name', 'slug', 'short_description', 'description', 'price_from', 'currency', 'local_price', 'tourist_price', 'duration_minutes', 'image', 'whatsapp', 'featured', 'active', 'booking_available'];

    protected function casts(): array
    {
        return ['price_from' => 'decimal:2', 'local_price' => 'decimal:2', 'tourist_price' => 'decimal:2', 'featured' => 'boolean', 'active' => 'boolean', 'booking_available' => 'boolean'];
    }
}
