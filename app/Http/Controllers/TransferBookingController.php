<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransferBookingRequest;
use App\Models\Transfer;
use App\Models\TransferBooking;
use App\Services\BookingTelegramNotifier;
use Illuminate\Http\RedirectResponse;
use Throwable;

class TransferBookingController extends Controller
{
    public function store(StoreTransferBookingRequest $request, BookingTelegramNotifier $notifier): RedirectResponse
    {
        $data = $request->validated();
        $transfer = Transfer::findOrFail($data['transfer_id']);
        $data['infants'] = $data['infants'] ?? 0;
        $data['adults'] = $data['passengers'];
        $data['children'] = $data['infants'];
        $data['preferred_time'] = $transfer->departure_time?->format('H:i');
        $rate = $data['customer_type'] === 'local' ? $transfer->local_price : $transfer->tourist_price;
        $data['quote_amount'] = $rate ? $rate * $data['passengers'] : null;
        $data['quote_currency'] = $data['customer_type'] === 'local' ? 'MVR' : $transfer->tourist_currency;
        $booking = TransferBooking::create($data);

        try {
            $notifier->transfer($booking);
        } catch (Throwable $exception) {
            report($exception);
        }

        return back()->with('success', "Your transfer request has been received. Reference: {$booking->reference}");
    }
}
