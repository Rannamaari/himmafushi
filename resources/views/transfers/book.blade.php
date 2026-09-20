<x-layouts.app :title="'Book '.$transfer->name.' | Himmafushi'" description="Confirm your Himmafushi speedboat request.">
    <section class="page-hero booking-page-hero"><div class="page-shell"><p class="eyebrow">Confirm your departure</p><h1>Book your speedboat</h1><p>Your selected date and time are held in this request for the booking team to confirm.</p></div></section>
    <section class="section"><div class="page-shell booking-layout">
        <aside class="booking-summary"><p class="eyebrow">Selected journey</p><h2>{{ $transfer->name }}</h2><dl><div><dt>Date</dt><dd>{{ $selectedDate->format('D, d M Y') }}</dd></div><div><dt>Departure</dt><dd>{{ $transfer->departure_time?->format('H:i') }}</dd></div><div><dt>Route</dt><dd>{{ $transfer->from_location }} to {{ $transfer->to_location }}</dd></div></dl>@if($transfer->local_price || $transfer->tourist_price)<div class="schedule-price">@if($transfer->local_price)<span>Local MVR {{ number_format($transfer->local_price, 0) }}</span>@endif @if($transfer->tourist_price)<span>Guest {{ $transfer->tourist_currency }} {{ number_format($transfer->tourist_price, 0) }}</span>@endif</div>@endif@if($transfer->notes)<p class="booking-note">{{ $transfer->notes }}</p>@endif<a class="text-link" href="{{ route('transfers.index', ['date' => $selectedDate->toDateString()]) }}">Change date or departure</a></aside>
        <div>
            @if(session('success'))<div class="booking-success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="booking-errors"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form method="POST" action="{{ route('transfer-bookings.store') }}" class="booking-form">
                @csrf
                <input type="hidden" name="transfer_id" value="{{ $transfer->id }}"><input type="hidden" name="travel_date" value="{{ $selectedDate->toDateString() }}"><input type="hidden" name="preferred_time" value="{{ $transfer->departure_time?->format('H:i') }}">
                <fieldset class="form-field full traveller-type"><legend>Traveller type</legend><div class="traveller-options"><label><input type="radio" name="customer_type" value="local" data-rate="{{ $transfer->local_price }}" data-currency="MVR" @checked(old('customer_type') === 'local')> <span>Local <small>MVR {{ number_format($transfer->local_price, 0) }} per guest</small></span></label><label><input type="radio" name="customer_type" value="tourist" data-rate="{{ $transfer->tourist_price }}" data-currency="{{ $transfer->tourist_currency }}" @checked(old('customer_type', 'tourist') === 'tourist')> <span>Tourist <small>{{ $transfer->tourist_currency }} {{ number_format($transfer->tourist_price, 0) }} per guest</small></span></label></div></fieldset>
                <div class="form-field full"><label for="name">Full name</label><input id="name" name="name" value="{{ old('name') }}" autocomplete="name" required></div>
                <div class="form-field"><label for="whatsapp">WhatsApp number</label><input id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="+960 7900000" autocomplete="tel" required></div><div class="form-field"><label for="email">Email address <span>optional</span></label><input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"></div>
                <div class="form-field"><label for="passengers">Chargeable guests <span>age 3+</span></label><input id="passengers" type="number" name="passengers" value="{{ old('passengers', 1) }}" min="1" max="50" required></div><div class="form-field"><label for="infants">Infants <span>age 0-2, free</span></label><input id="infants" type="number" name="infants" value="{{ old('infants', 0) }}" min="0" max="20"></div>
                <div class="form-field"><label for="flight_number">Flight number <span>optional</span></label><input id="flight_number" name="flight_number" value="{{ old('flight_number') }}" placeholder="e.g. EK652"></div><div class="form-field"><label for="flight_time">Flight time <span>optional</span></label><input id="flight_time" type="time" name="flight_time" value="{{ old('flight_time') }}"></div>
                <div class="form-field full"><label for="notes">Anything the team should know? <span>optional</span></label><textarea id="notes" name="notes" rows="4" placeholder="Luggage, arrival details, special assistance...">{{ old('notes') }}</textarea></div>
                <div class="form-field full"><div class="fare-estimate" aria-live="polite"><span>Estimated transfer fare</span><strong id="fare-total"></strong><small id="fare-detail"></small></div><button class="button booking-submit" type="submit">Confirm transfer request</button></div>
            </form>
        </div>
    </div></section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('.booking-form');
            const passengers = form?.querySelector('[name="passengers"]');
            const total = document.querySelector('#fare-total');
            const detail = document.querySelector('#fare-detail');
            const updateFare = () => {
                const selected = form.querySelector('[name="customer_type"]:checked');
                const count = Math.max(1, Number(passengers.value) || 1);
                const rate = Number(selected.dataset.rate);
                total.textContent = `${selected.dataset.currency} ${(rate * count).toLocaleString()}`;
                detail.textContent = `${count} chargeable guest${count === 1 ? '' : 's'} x ${selected.dataset.currency} ${rate.toLocaleString()}.`;
            };
            form.querySelectorAll('[name="customer_type"]').forEach((option) => option.addEventListener('change', updateFare));
            passengers.addEventListener('input', updateFare);
            updateFare();
        });
    </script>
</x-layouts.app>
