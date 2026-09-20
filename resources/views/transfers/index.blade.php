<x-layouts.app title="Himmafushi Speedboat Schedule & Booking" description="Choose a travel date, view operating Himmafushi speedboats and submit a transfer request.">
    <section class="page-hero">
        <div class="page-shell">
            <p class="eyebrow">Date-first booking</p>
            <h1>Transfers to Himmafushi</h1>
            <p>Choose your travel date, select a published departure, then send one clear request to our booking team.</p>
        </div>
    </section>

    <section class="section transfer-schedule-section">
        <div class="page-shell">
            <div class="schedule-toolbar">
                <div><p class="eyebrow">Plan your journey</p><h2>When would you like to travel?</h2></div>
                <form class="transfer-date-form" method="GET" action="{{ route('transfers.index') }}">
                    <label for="travel-date">Travel date</label>
                    <div><input id="travel-date" type="date" name="date" value="{{ $selectedDate->toDateString() }}" min="{{ now()->toDateString() }}" onchange="this.form.submit()"><button class="button" type="submit">Show departures</button></div>
                </form>
            </div>

            <div class="schedule-date-banner"><strong>{{ $selectedDate->format('l, d F Y') }}</strong><span>{{ $transfers->count() }} scheduled departure{{ $transfers->count() === 1 ? '' : 's' }} available</span></div>

            <div class="schedule-service-grid">
                @forelse($transfers->groupBy('name') as $operator => $operatorTransfers)
                    <article class="schedule-service">
                        <header><p class="eyebrow">Scheduled speedboat</p><h2>{{ $operator }}</h2></header>
                        @foreach($operatorTransfers->groupBy(fn ($transfer) => $transfer->from_location.'|'.$transfer->to_location) as $route => $departures)
                            @php([$from, $to] = explode('|', $route, 2))
                            <section class="schedule-route">
                                <p>{{ $from }} <span>to</span> {{ $to }}</p>
                                <div class="schedule-slots">@foreach($departures as $transfer)<a class="schedule-slot" href="{{ route('transfers.book', ['transfer' => $transfer, 'date' => $selectedDate->toDateString()]) }}"><strong>{{ $transfer->departure_time?->format('H:i') }}</strong><span>Choose</span></a>@endforeach</div>
                                @if($departures->first()->tourist_price || $departures->first()->local_price)<div class="schedule-price">@if($departures->first()->local_price)<span>Local MVR {{ number_format($departures->first()->local_price, 0) }}</span>@endif @if($departures->first()->tourist_price)<span>Guest {{ $departures->first()->tourist_currency }} {{ number_format($departures->first()->tourist_price, 0) }}</span>@endif</div>@endif
                            </section>
                        @endforeach
                    </article>
                @empty
                    <x-empty-state title="No scheduled departures for this date" message="Try another date or contact us for a private transfer request." />
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.app>
