<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuesthouseBookingRequest;
use App\Models\GuesthouseBookingRequest;
use App\Services\BookingTelegramNotifier;
use Illuminate\Http\RedirectResponse;
use Throwable;

class GuesthouseBookingController extends Controller
{
    public function store(StoreGuesthouseBookingRequest $request, BookingTelegramNotifier $notifier): RedirectResponse
    {
        $data = $request->validated();
        $data['children'] = $data['children'] ?? 0;
        $booking = GuesthouseBookingRequest::create($data);

        try {
            $notifier->guesthouse($booking);
        } catch (Throwable $exception) {
            report($exception);
        }

        return back()->with('success', "Your accommodation request has been received. Reference: {$booking->reference}");
    }
}
