<?php

namespace App\Services;

use App\Models\ActivityBookingRequest;
use App\Models\GuesthouseBookingRequest;
use App\Models\SiteSetting;
use App\Models\TransferBooking;

class BookingTelegramNotifier
{
    public function __construct(protected TelegramService $telegram) {}

    public function transfer(TransferBooking $booking): void
    {
        $booking->loadMissing('transfer');

        $transfer = $booking->transfer;
        $message =
            "<b>🚤 NEW TRANSFER BOOKING</b>\n\n".
            "<b>Reference:</b> {$this->h($booking->reference)}\n".
            "<b>Customer:</b> {$this->h($booking->name)}\n".
            "<b>Type:</b> {$this->h(strtoupper($booking->customer_type))}\n".
            "<b>WhatsApp:</b> {$this->h($booking->whatsapp)}\n".
            "<b>Country:</b> {$this->h($booking->country ?: '-')}\n\n".
            "<b>Transfer:</b> {$this->h($transfer?->name ?: 'Custom request')}\n".
            "<b>From:</b> {$this->h($transfer?->from_location ?: $booking->pickup_location)}\n".
            "<b>To:</b> {$this->h($transfer?->to_location ?: $booking->dropoff_location)}\n\n".
            "<b>Date:</b> {$this->h($booking->travel_date->format('d M Y'))}\n".
            "<b>Preferred Time:</b> {$this->h($booking->preferred_time ?: '-')}\n".
            "<b>Chargeable guests (age 3+):</b> {$booking->passengers}\n".
            "<b>Infants (age 0-2, free):</b> {$booking->infants}\n".
            "<b>Estimated fare:</b> {$this->h($booking->quote_currency ?: '-')} {$this->h($booking->quote_amount ? number_format((float) $booking->quote_amount, 2) : 'On request')}\n\n".
            "<b>Flight:</b> {$this->h($booking->flight_number ?: '-')}\n".
            "<b>Flight Time:</b> {$this->h($booking->flight_time ?: '-')}\n\n".
            "<b>Notes:</b>\n{$this->h($booking->notes ?: '-')}";

        $whatsappMessage =
            "Hello {$booking->name}, we have received your Himmafushi transfer request. ".
            "Your booking reference is {$booking->reference}. ".
            'We are checking availability and the best rate for you.';

        $this->telegram->send(SiteSetting::configuredValue('telegram_transfer_chat_id', config('services.telegram.transfer_chat_id')), $message, [
            [
                ['text' => '💬 WhatsApp Customer', 'url' => $booking->whatsappUrl($whatsappMessage)],
                ['text' => '⚙️ Open Booking', 'url' => config('app.url')."/admin/transfer-bookings/{$booking->id}/edit"],
            ],
        ]);
    }

    public function guesthouse(GuesthouseBookingRequest $booking): void
    {
        $booking->loadMissing('guesthouse');

        $message =
            "<b>🏨 NEW GUESTHOUSE REQUEST</b>\n\n".
            "<b>Reference:</b> {$this->h($booking->reference)}\n".
            "<b>Guesthouse:</b> {$this->h($booking->guesthouse?->name ?: 'Any Guesthouse')}\n\n".
            "<b>Customer:</b> {$this->h($booking->name)}\n".
            "<b>WhatsApp:</b> {$this->h($booking->whatsapp)}\n".
            "<b>Nationality:</b> {$this->h($booking->country ?: '-')}\n\n".
            "<b>Notes:</b>\n{$this->h($booking->notes ?: '-')}";

        $whatsappMessage =
            "Hello {$booking->name}, we have received your Himmafushi accommodation request. ".
            "Your reference is {$booking->reference}. ".
            'We will contact you here shortly to confirm your dates and find the best available rate.';

        $this->telegram->send(SiteSetting::configuredValue('telegram_guesthouse_chat_id', config('services.telegram.guesthouse_chat_id')), $message, [
            [
                ['text' => '💬 WhatsApp Guest', 'url' => $booking->whatsappUrl($whatsappMessage)],
                ['text' => '⚙️ Open Request', 'url' => config('app.url')."/admin/guesthouse-booking-requests/{$booking->id}/edit"],
            ],
        ]);
    }

    public function activity(ActivityBookingRequest $booking): void
    {
        $booking->loadMissing('activity');
        $message =
            "<b>🌊 NEW EXCURSION BOOKING REQUEST</b>\n\n".
            "<b>Reference:</b> {$this->h($booking->reference)}\n".
            "<b>Activity:</b> {$this->h($booking->activity_name)}\n".
            "<b>Date:</b> {$booking->preferred_date->format('d M Y')}\n".
            "<b>Guests:</b> {$booking->participants}\n".
            "<b>Name:</b> {$this->h($booking->name)}\n".
            "<b>WhatsApp:</b> {$this->h($booking->whatsapp)}\n".
            "<b>Nationality:</b> {$this->h($booking->nationality ?: '-')}\n".
            "<b>Estimated total:</b> {$this->h($booking->currency)} {$this->h($booking->estimated_total ? number_format((float) $booking->estimated_total, 2) : 'Confirm with operator')}\n\n".
            "<b>Notes:</b>\n{$this->h($booking->notes ?: '-')}";

        $whatsappMessage = "Hello {$booking->name}, we received your advance booking request for {$booking->activity_name} on {$booking->preferred_date->format('d M Y')}. We will confirm availability and the special rate shortly. Reference: {$booking->reference}.";

        $chatId = SiteSetting::configuredValue(
            'telegram_excursion_chat_id',
            SiteSetting::configuredValue('telegram_guesthouse_chat_id', config('services.telegram.guesthouse_chat_id')),
        );

        $this->telegram->send($chatId, $message, [[
            ['text' => '💬 WhatsApp Guest', 'url' => $booking->whatsappUrl($whatsappMessage)],
            ['text' => '⚙️ Open Request', 'url' => config('app.url')."/admin/activity-booking-requests/{$booking->id}/edit"],
        ]]);
    }

    private function h(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
