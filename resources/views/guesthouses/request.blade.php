<x-layouts.app
    :title="'Request the Best Rate for '.$guesthouse->name.' | Himmafushi'"
    :description="'Send your name, WhatsApp number and nationality to request the best available rate for '.$guesthouse->name.'.'"
    :image="$guesthouse->image ?: data_get($guesthouse->gallery, 0)"
    :image-alt="$guesthouse->name.' guesthouse in Himmafushi, Maldives'"
    robots="noindex,follow"
>
    <section class="page-hero request-rate-hero"><div class="page-shell"><p class="eyebrow">Direct rate request</p><h1>Request the best rate.</h1><p>Tell us how to reach you. We will continue personally on WhatsApp and help with dates, rooms, and the best available offer for {{ $guesthouse->name }}.</p></div></section>

    <section class="section section-tint"><div class="page-shell quick-request-layout">
        <aside class="quick-request-stay">
            @if($guesthouse->image)<img src="{{ asset('storage/'.$guesthouse->image) }}" alt="{{ $guesthouse->name }}" loading="eager">@endif
            <div><p class="eyebrow">Your selected stay</p><h2>{{ $guesthouse->name }}</h2><p>{{ $guesthouse->excerpt ?: str(strip_tags($guesthouse->description ?: ''))->limit(145) }}</p><a class="text-link" href="{{ route('guesthouses.show', $guesthouse) }}">View guesthouse</a></div>
        </aside>

        <div>
            @if(session('success'))<div class="booking-success"><strong>Request received.</strong><p>{{ session('success') }}</p><p>Keep an eye on WhatsApp. We will contact you there shortly.</p></div>@endif
            @if($errors->any())<div class="booking-errors"><strong>Please check the details below.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

            <form method="POST" action="{{ route('guesthouse-bookings.store') }}" class="booking-form quick-request-form">
                @csrf
                <input type="hidden" name="guesthouse_id" value="{{ $guesthouse->id }}">
                <div class="form-field full"><label for="name">Your name</label><input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="Full name" required></div>
                <div class="form-field full"><label for="whatsapp">WhatsApp phone number</label><input id="whatsapp" type="tel" name="whatsapp" value="{{ old('whatsapp') }}" autocomplete="tel" inputmode="tel" placeholder="Include country code, e.g. +960 7779493" required><p class="form-help">We will use this number to continue your request on WhatsApp.</p></div>
                <div class="form-field full"><label for="country">Nationality</label><select id="country" name="country" autocomplete="country-name" required><option value="">Select your nationality</option>@foreach(\App\Support\Countries::all() as $country)<option value="{{ $country }}" @selected(old('country') === $country)>{{ $country }}</option>@endforeach</select></div>
                <div class="form-field full"><label for="notes">Anything else? <span>Optional</span></label><textarea id="notes" name="notes" rows="4" placeholder="Travel dates, number of guests, room preference, or anything you would like us to know">{{ old('notes') }}</textarea></div>
                <div class="form-field full"><button type="submit" class="button booking-submit">Send Best Rate Request</button><p class="form-help">No long form. We will contact you personally on WhatsApp to complete the details.</p></div>
            </form>
        </div>
    </div></section>
</x-layouts.app>
