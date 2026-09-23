<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityBookingRequest extends Model
{
    protected $fillable = [
        'activity_id', 'activity_name', 'preferred_date', 'participants', 'name', 'whatsapp',
        'nationality', 'notes', 'estimated_total', 'currency', 'status',
    ];

    protected function casts(): array
    {
        return ['preferred_date' => 'date', 'participants' => 'integer', 'estimated_total' => 'decimal:2'];
    }

    protected static function booted(): void
    {
        static::created(function (ActivityBookingRequest $booking): void {
            if (! $booking->reference) {
                $booking->forceFill(['reference' => 'EX-'.now()->format('ymd').'-'.str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT)])->saveQuietly();
            }
        });
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function whatsappUrl(string $message = ''): string
    {
        $number = preg_replace('/\D+/', '', $this->whatsapp);

        return 'https://wa.me/'.$number.($message ? '?text='.rawurlencode($message) : '');
    }
}
