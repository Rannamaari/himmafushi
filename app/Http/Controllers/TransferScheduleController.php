<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransferScheduleController extends Controller
{
    public function index(Request $request): View
    {
        $selectedDate = $this->selectedDate($request);
        $day = strtolower($selectedDate->englishDayOfWeek);

        $transfers = Transfer::query()
            ->where('active', true)
            ->orderBy('name')
            ->orderBy('from_location')
            ->orderBy('departure_time')
            ->get()
            ->filter(fn (Transfer $transfer): bool => in_array($day, $transfer->operating_days ?? [], true));

        return view('transfers.index', compact('selectedDate', 'transfers'));
    }

    public function book(Request $request, Transfer $transfer): View
    {
        abort_unless($transfer->active, 404);

        return view('transfers.book', [
            'transfer' => $transfer,
            'selectedDate' => $this->selectedDate($request),
        ]);
    }

    private function selectedDate(Request $request): CarbonImmutable
    {
        $value = (string) $request->query('date', now()->toDateString());

        try {
            $date = CarbonImmutable::createFromFormat('!Y-m-d', $value);

            return $date->format('Y-m-d') === $value && $date->greaterThanOrEqualTo(CarbonImmutable::today())
                ? $date
                : CarbonImmutable::today();
        } catch (\Throwable) {
            return CarbonImmutable::today();
        }
    }
}
