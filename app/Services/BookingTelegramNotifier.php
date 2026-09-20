<?php

namespace App\Services;

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
            "<b>Type:</b> {$this->h(strtoupper($booking->customer_type))}\n".
            "<b>WhatsApp:</b> {$this->h($booking->whatsapp)}\n".
            "<b>Country:</b> {$this->h($booking->country ?: '-')}\n\n".
            "<b>Check-in:</b> {$booking->check_in->format('d M Y')}\n".
            "<b>Check-out:</b> {$booking->check_out->format('d M Y')}\n\n".
            "<b>Adults:</b> {$booking->adults}\n".
            "<b>Children:</b> {$booking->children}\n".
            "<b>Room:</b> {$this->h($booking->room_preference ?: '-')}\n".
            "<b>Meal Plan:</b> {$this->h($booking->meal_plan ?: '-')}\n\n".
            "<b>Notes:</b>\n{$this->h($booking->notes ?: '-')}";

        $whatsappMessage =
            "Hello {$booking->name}, we have received your Himmafushi accommodation request. ".
            "Your reference is {$booking->reference}. ".
            'We are checking the best available rate for your dates.';

        $this->telegram->send(SiteSetting::configuredValue('telegram_guesthouse_chat_id', config('services.telegram.guesthouse_chat_id')), $message, [
            [
                ['text' => '💬 WhatsApp Guest', 'url' => $booking->whatsappUrl($whatsappMessage)],
                ['text' => '⚙️ Open Request', 'url' => config('app.url')."/admin/guesthouse-booking-requests/{$booking->id}/edit"],
            ],
        ]);
    }

    private function h(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
