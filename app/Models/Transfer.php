<?php

namespace App\Models;

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
        'active',
    ];

    protected function casts(): array
    {
        return [
            'departure_time' => 'datetime:H:i',
            'operating_days' => 'array',
            'active' => 'boolean',
            'local_price' => 'decimal:2',
            'tourist_price' => 'decimal:2',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(TransferBooking::class);
    }
}
