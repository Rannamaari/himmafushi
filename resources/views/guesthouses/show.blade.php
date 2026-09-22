<x-layouts.app
    :title="$guesthouse->name.' | Himmafushi Guesthouse'"
    :description="$guesthouse->excerpt ?: str(strip_tags($guesthouse->description ?: ''))->limit(160) ?: 'Request a stay at '.$guesthouse->name.' in Himmafushi, Maldives.'"
    :image="$guesthouse->image ?: data_get($guesthouse->gallery, 0)"
    :image-alt="$guesthouse->name.' guesthouse in Himmafushi, Maldives'"
    type="website"
>
    <section class="detail-hero">
        @if($guesthouse->image)<img src="{{ asset('storage/'.$guesthouse->image) }}" alt="{{ $guesthouse->name }}" loading="eager">@endif
        <div class="page-shell"><p class="eyebrow">Island stay</p><h1>{{ $guesthouse->name }}</h1><p>{{ $guesthouse->address ?: 'Himmafushi, Maldives' }}</p></div>
    </section>

    <section class="section">
        <div class="page-shell detail-grid">
            <article class="prose article-body">
                <h2>Your Himmafushi stay</h2>
                @if($guesthouse->description)
                    {!! $guesthouse->description !!}
                @else
                    <p>Ask for availability and the best rate for your dates.</p>
                @endif

                <div class="rate-panel"><h3>Rates</h3>@if($guesthouse->local_rate_from)<p>Maldives Local / Resident: from MVR {{ number_format($guesthouse->local_rate_from, 0) }}</p>@endif @if($guesthouse->tourist_rate_from)<p>International Guest: from USD {{ number_format($guesthouse->tourist_rate_from, 0) }}</p>@endif @if(! $guesthouse->local_rate_from && ! $guesthouse->tourist_rate_from)<p>Request a rate for your dates and guest count.</p>@endif</div>

                @if($guesthouse->deals->isNotEmpty())
                    <section class="guesthouse-deals" aria-labelledby="guesthouse-deals-title"><p class="eyebrow">Available offer</p><h2 id="guesthouse-deals-title">Deals at {{ $guesthouse->name }}</h2>
                        @foreach($guesthouse->deals as $deal)<article class="guesthouse-deal"><div><h3>{{ $deal->title }}</h3><p>{{ $deal->description ?: 'Ask for this offer when you send your stay request.' }}</p>@if($deal->ends_at)<small>Available until {{ $deal->ends_at->format('j M Y') }}</small>@endif</div><div class="guesthouse-deal-price">@if($deal->deal_price)<strong>{{ $deal->currency }} {{ number_format($deal->deal_price, 0) }}</strong>@if($deal->original_price)<del>{{ $deal->currency }} {{ number_format($deal->original_price, 0) }}</del>@endif @else<strong>Special offer</strong>@endif<span>{{ $deal->customer_type === 'all' ? 'For all guests' : ucfirst($deal->customer_type).' offer' }}</span></div></article>@endforeach
                    </section>
                @endif
            </article>
            <aside class="contact-card"><h2>Request best rate</h2><p>Send your dates and guest count. We will confirm availability directly.</p><a class="button" href="{{ route('guesthouses.request', $guesthouse) }}">Request Best Rate</a>@if($guesthouse->phone)<a class="button button-outline" href="tel:{{ $guesthouse->phone }}">Call guesthouse</a>@endif</aside>
        </div>

        @if(filled($guesthouse->gallery))
            <section class="page-shell listing-gallery" aria-labelledby="guesthouse-gallery-title">
                <div><p class="eyebrow">Take a closer look</p><h2 id="guesthouse-gallery-title">Photos of {{ $guesthouse->name }}</h2></div>
                <div class="listing-gallery-grid">@foreach($guesthouse->gallery as $photo)<a href="{{ asset('storage/'.$photo) }}" target="_blank" rel="noopener"><img src="{{ asset('storage/'.$photo) }}" alt="{{ $guesthouse->name }} photo {{ $loop->iteration }}" loading="lazy"></a>@endforeach</div>
            </section>
        @endif
    </section>
</x-layouts.app>
