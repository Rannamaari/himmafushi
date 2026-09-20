<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferBooking extends Model
{
    protected $fillable = [
        'transfer_id',
        'customer_type',
        'name',
        'whatsapp',
        'email',
        'country',
        'travel_date',
        'preferred_time',
        'adults',
        'children',
        'passengers',
        'infants',
        'flight_number',
        'flight_time',
        'pickup_location',
        'dropoff_location',
        'notes',
        'status',
        'quote_amount',
        'quote_currency',
        'supplier_confirmation',
    ];

    protected function casts(): array
    {
        return [
            'travel_date' => 'date',
            'quote_amount' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (TransferBooking $booking) {
            if (! $booking->reference) {
                $booking->forceFill([
                    'reference' => 'TR-'.
                        now()->format('ymd').
                        '-'.
                        str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT),
                ])->saveQuietly();
            }
        });
    }

    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }

    public function whatsappUrl(string $message = ''): string
    {
        $number = preg_replace('/\D+/', '', $this->whatsapp);

        return 'https://wa.me/'.$number.
            ($message ? '?text='.rawurlencode($message) : '');
    }
}
