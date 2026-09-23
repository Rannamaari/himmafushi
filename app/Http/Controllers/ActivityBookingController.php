<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityBookingRequest;
use App\Models\Activity;
use App\Models\ActivityBookingRequest as ActivityBooking;
use App\Services\BookingTelegramNotifier;
use Illuminate\Http\RedirectResponse;
use Throwable;

class ActivityBookingController extends Controller
{
    public function store(StoreActivityBookingRequest $request, BookingTelegramNotifier $notifier): RedirectResponse
    {
        $data = $request->validated();
        $activity = Activity::query()->whereKey($data['activity_id'])->where('active', true)->where('booking_available', true)->firstOrFail();
        $data['activity_name'] = $activity->name;
        $data['currency'] = 'USD';
        $data['estimated_total'] = $activity->priceForParticipants((int) $data['participants']);
        $booking = ActivityBooking::create($data);

        try {
            $notifier->activity($booking);
        } catch (Throwable $exception) {
            report($exception);
        }

        return back()->with('activity_booking_success', "Your advance booking request is in. Reference: {$booking->reference}");
    }
}
