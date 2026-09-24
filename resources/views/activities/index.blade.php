<x-layouts.app
    title="Things to Do in Himmafushi | Excursion Prices & Advance Booking"
    description="Explore Himmafushi surf trips, snorkelling, island hopping, fishing and sandbank packages. See Ocean Monkey prices and request an advance booking with local help."
    :image="'images/himmafushi-hero.png'"
    image-alt="Himmafushi island and lagoon, home to Ocean Monkey excursions"
>
    <section class="activities-hero">
        <img src="{{ asset('images/himmafushi-hero.png') }}" alt="The turquoise lagoon around Himmafushi" fetchpriority="high">
        <div class="activities-hero-shade"></div>
        <div class="page-shell activities-hero-content">
            <p class="eyebrow light">Plan ahead. Get on the water.</p>
            <h1>Things to do<br>in Himmafushi</h1>
            <p>Surf breaks, reef life, island visits and unforgettable days at sea. Browse the current partner prices and send us your dates to book ahead.</p>
            <a class="button" href="#excursion-prices">Explore excursions <span aria-hidden="true">↓</span></a>
        </div>
    </section>

    <section class="ocean-monkey-band">
        <div class="page-shell ocean-monkey-inner">
            <img src="{{ asset('images/ocean-monkey-logo-color.png') }}" alt="Ocean Monkey Himmafushi logo" width="900" height="755" loading="lazy">
            <div><p class="eyebrow">Our local excursion partner</p><h2>Ocean Monkey Himmafushi</h2><p>Book through us in advance. We will coordinate with Ocean Monkey, check your preferred date, and ask about any available special rate before confirming.</p></div>
            <a class="text-link" href="https://wa.me/9607779493?text={{ urlencode('Hello, I would like to ask about Ocean Monkey excursions in Himmafushi and any available special rates.') }}" target="_blank" rel="noopener">Ask about special rates <span aria-hidden="true">→</span></a>
        </div>
    </section>

    <section id="excursion-prices" class="section activity-catalogue">
        <div class="page-shell">
            <div class="activity-catalogue-heading"><div><p class="eyebrow">Current excursion list · USD per person</p><h2>Pick your kind of day</h2><p>Choose an excursion and send us a booking request. We’ll check availability and confirm the details and price with Ocean Monkey.</p></div><div class="activity-price-note"><strong>Going with a group?</strong><span>Per-person rates reduce for larger groups on many trips.</span></div></div>

            @php($groupedActivities = $activities->groupBy(fn ($activity) => $activity->category ?: 'Other experiences'))
            @forelse($groupedActivities as $category => $items)
                <section class="activity-category" aria-labelledby="activity-category-{{ $loop->index }}">
                    <div class="activity-category-heading"><span>{{ str_pad((string) ($loop->iteration), 2, '0', STR_PAD_LEFT) }}</span><h3 id="activity-category-{{ $loop->index }}">{{ $category }}</h3><i></i></div>
                    <div class="activity-price-grid">
                        @foreach($items as $activity)
                            <article class="activity-price-card">
                                <div class="activity-price-card-top">
                                    <div class="activity-price-icon" aria-hidden="true">{{ match ($category) { 'Surfing' => '↗', 'Snorkelling' => '◉', 'Fishing' => '⌁', 'Cruises' => '≈', 'Island Hopping' => '⌖', 'Packages' => '✳', default => '↗' } }}</div>
                                    <div><p class="activity-card-category">{{ $category }}</p><h4>{{ $activity->name }}</h4></div>
                                </div>
                                <p class="activity-card-description">{{ $activity->short_description ?: $activity->description }}</p>
                                @if($activity->slug === 'surf-jails-sultans-honkeys')<p class="activity-minimum-note">Minimum 3 guests</p>@endif
                                <div class="activity-tier-list" aria-label="Prices per person">
                                    @foreach($activity->price_tiers ?? [] as $tier)
                                        <div><span>{{ $tier['label'] }}</span><strong>USD {{ number_format((float) $tier['amount'], 0) }}</strong></div>
                                    @endforeach
                                </div>
                                @if($activity->slug === 'sunset-fishing')<p class="activity-inclusions">Fishing materials &amp; bait included</p>@endif
                                @if($activity->slug === 'nurse-shark-sandbank-package')<p class="activity-inclusions">Lunch, juice &amp; water included</p>@endif
                                @if($activity->slug === 'two-snorkel-points-sandbank-package')<p class="activity-inclusions">Lunch included</p>@endif
                                <button class="activity-book-button" type="button" data-book-activity="{{ $activity->id }}">Book in advance <span aria-hidden="true">→</span></button>
                            </article>
                        @endforeach
                    </div>
                </section>
            @empty
                <div class="activity-empty-state"><h3>Excursion rates are being updated</h3><p>Call or WhatsApp us and we will check current options for your dates.</p><a class="button" href="tel:+9607779493">Call +960 7779493</a></div>
            @endforelse
        </div>
    </section>

    <section id="book-experience" class="section activity-booking-section">
        <div class="page-shell activity-booking-layout">
            <div class="activity-booking-copy"><p class="eyebrow light">Reserve before you arrive</p><h2>Let us arrange your excursion.</h2><p>Send your activity, date and group size. We will check the boat, availability and any special rate with Ocean Monkey, then follow up with you directly on WhatsApp.</p><div class="activity-booking-points"><span>Advance booking</span><span>Local coordination</span><span>Final details confirmed with you</span></div><img src="{{ asset('images/ocean-monkey-logo-color.png') }}" alt="Ocean Monkey Himmafushi" loading="lazy"></div>
            <div class="activity-booking-form-wrap">
                @if(session('activity_booking_success'))<div class="booking-success"><strong>Request sent.</strong><p>{{ session('activity_booking_success') }}</p><p>We will confirm the details with you on WhatsApp.</p></div>@endif
                @if($errors->any())<div class="booking-errors"><strong>Please check your request.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <form class="booking-form activity-booking-form" method="POST" action="{{ route('activity-bookings.store') }}" id="activity-booking-form">
                    @csrf
                    <div class="form-field full"><label for="activity_id">Choose an excursion</label><select name="activity_id" id="activity_id" required><option value="">Select an experience</option>@foreach($activities as $activity)<option value="{{ $activity->id }}" data-one="{{ $activity->priceForParticipants(1) ?? '' }}" data-two="{{ $activity->priceForParticipants(2) ?? '' }}" data-three="{{ $activity->priceForParticipants(3) ?? '' }}" data-four="{{ $activity->priceForParticipants(4) ?? '' }}" data-five="{{ $activity->priceForParticipants(5) ?? '' }}" @selected(old('activity_id', request('activity')) == $activity->id)>{{ $activity->name }}</option>@endforeach</select></div>
                    <div class="form-field"><label for="preferred_date">Preferred date</label><input type="date" name="preferred_date" id="preferred_date" min="{{ now()->toDateString() }}" value="{{ old('preferred_date') }}" required></div>
                    <div class="form-field"><label for="participants">Number of guests</label><input type="number" name="participants" id="participants" min="1" max="30" value="{{ old('participants', 2) }}" required></div>
                    <div class="activity-estimate full" data-activity-estimate aria-live="polite"><span>Indicative total</span><strong>Select an excursion and group size</strong><small>Final price and availability are confirmed before booking.</small></div>
                    <div class="form-field full"><label for="activity-name">Your name</label><input type="text" name="name" id="activity-name" autocomplete="name" value="{{ old('name') }}" required></div>
                    <div class="form-field full"><label for="activity-whatsapp">WhatsApp number</label><input type="tel" name="whatsapp" id="activity-whatsapp" autocomplete="tel" inputmode="tel" placeholder="Include country code" value="{{ old('whatsapp') }}" required></div>
                    <div class="form-field full"><label for="activity-nationality">Nationality <span>Optional</span></label><input type="text" name="nationality" id="activity-nationality" value="{{ old('nationality') }}"></div>
                    <div class="form-field full"><label for="activity-notes">Anything we should know? <span>Optional</span></label><textarea name="notes" id="activity-notes" rows="3" placeholder="Surf level, children joining, equipment needs...">{{ old('notes') }}</textarea></div>
                    <div class="form-field full"><button class="button booking-submit" type="submit">Send advance booking request</button><p class="form-help">This is a request, not a payment. We will confirm the excursion and rate with you first.</p></div>
                </form>
            </div>
        </div>
    </section>

    <script>
        (() => {
            const form = document.getElementById('activity-booking-form');
            if (!form) return;
            const activity = form.querySelector('#activity_id');
            const guests = form.querySelector('#participants');
            const estimate = form.querySelector('[data-activity-estimate]');
            const refresh = () => {
                const option = activity.selectedOptions[0];
                const count = Number(guests.value || 0);
                const key = count <= 1 ? 'one' : count === 2 ? 'two' : count === 3 ? 'three' : count === 4 ? 'four' : 'five';
                const unit = option?.dataset[key];
                if (!option?.value || !count) {
                    estimate.innerHTML = '<span>Indicative total</span><strong>Select an excursion and group size</strong><small>Final price and availability are confirmed before booking.</small>';
                } else if (!unit) {
                    estimate.innerHTML = '<span>Rate on request</span><strong>We will confirm this group rate</strong><small>This group size is not listed on the current price board.</small>';
                } else {
                    estimate.innerHTML = `<span>Estimated total · ${count} guest${count === 1 ? '' : 's'}</span><strong>USD ${(Number(unit) * count).toFixed(0)}</strong><small>USD ${Number(unit).toFixed(0)} per person. Final amount confirmed by the operator.</small>`;
                }
            };
            activity.addEventListener('change', refresh);
            guests.addEventListener('input', refresh);
            form.querySelectorAll('[data-book-activity]').forEach(button => button.addEventListener('click', () => {
                activity.value = button.dataset.bookActivity;
                refresh();
                document.getElementById('book-experience').scrollIntoView({ behavior: 'smooth' });
                window.setTimeout(() => activity.focus({ preventScroll: true }), 450);
            }));
            refresh();
        })();
    </script>
</x-layouts.app>
