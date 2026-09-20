<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guesthouse extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'phone',
        'email',
        'image',
        'local_rate_from',
        'tourist_rate_from',
        'featured',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
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
}
