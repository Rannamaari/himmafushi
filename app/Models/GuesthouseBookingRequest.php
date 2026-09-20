<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuesthouseBookingRequest extends Model
{
    protected $fillable = [
        'guesthouse_id',
        'customer_type',
        'name',
        'whatsapp',
        'email',
        'country',
        'check_in',
        'check_out',
        'adults',
        'children',
        'room_preference',
        'meal_plan',
        'notes',
        'status',
        'quote_amount',
        'quote_currency',
        'supplier_confirmation',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'quote_amount' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (GuesthouseBookingRequest $booking) {
            if (! $booking->reference) {
                $booking->forceFill([
                    'reference' => 'GH-'.
                        now()->format('ymd').
                        '-'.
                        str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT),
                ])->saveQuietly();
            }
        });
    }

    public function guesthouse(): BelongsTo
    {
        return $this->belongsTo(Guesthouse::class);
    }

    public function whatsappUrl(string $message = ''): string
    {
        $number = preg_replace('/\D+/', '', $this->whatsapp);

        return 'https://wa.me/'.$number.
            ($message ? '?text='.rawurlencode($message) : '');
    }
}
