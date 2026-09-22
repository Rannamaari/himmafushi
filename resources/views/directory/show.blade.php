<x-layouts.app
    :title="$business->name.($business->category->slug === 'restaurant' ? ' - Menu & Information | Himmafushi' : ' | Himmafushi Maldives')"
    :description="$business->short_description ?: 'Information for '.$business->name.' in Himmafushi.'"
    :image="$business->cover_image ?: $business->image ?: data_get($business->gallery, 0)"
    :image-alt="$business->name.' in Himmafushi, Maldives'"
    type="business.business"
>
    <section class="detail-hero">
        @if ($business->cover_image)
            <img src="{{ asset('storage/'.$business->cover_image) }}" alt="{{ $business->name }}">
        @endif

        <div class="page-shell">
            <p class="eyebrow">{{ $business->category->name }}</p>
            <h1>{{ $business->name }}</h1>
            <p>{{ $business->short_description }}</p>
        </div>
    </section>

    <section class="section">
        <div class="page-shell detail-grid">
            <article class="prose article-body">
                <h2>About {{ $business->name }}</h2>
                @if($business->description)
                    {!! $business->description !!}
                @else
                    <p>More information will be added by this local business soon.</p>
                @endif

                @if ($business->menuCategories->isNotEmpty())
                    <h2>Menu</h2>
                    @foreach ($business->menuCategories as $menuCategory)
                        <div class="menu-group">
                            <h3>{{ $menuCategory->name }}</h3>
                            @foreach ($menuCategory->items as $item)
                                <div class="menu-item">
                                    <div>
                                        <strong>{{ $item->name }}</strong>
                                        @if ($item->description)
                                            <span>{{ $item->description }}</span>
                                        @endif
                                    </div>
                                    <b>{{ $item->price ? $item->currency.' '.number_format($item->price, 0) : 'Ask for price' }}</b>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif

                @if ($business->services->isNotEmpty())
                    <h2>Services</h2>
                    <div class="service-list">
                        @foreach ($business->services as $service)
                            <div>
                                <strong>{{ $service->name }}</strong>
                                <span>{{ $service->description }}</span>
                                <b>{{ $service->price ? $service->currency.' '.number_format($service->price, 0) : 'Ask for price' }}</b>
                            </div>
                        @endforeach
                    </div>
                @endif
            </article>

            <aside class="contact-card">
                <h2>Contact</h2>
                @if ($business->opening_time || $business->closing_time)
                    <p><strong>Hours</strong><br>{{ $business->opening_time?->format('H:i') ?: 'Ask' }} - {{ $business->closing_time?->format('H:i') ?: 'Ask' }}</p>
                @endif
                @if ($business->address)
                    <p><strong>Location</strong><br>{{ $business->address }}</p>
                @endif
                @if ($business->phone)
                    <a class="button button-outline" href="tel:{{ $business->phone }}">Call {{ $business->phone }}</a>
                @endif
                <x-whatsapp-button :url="$business->whatsappUrl('Hello, I found '.$business->name.' on Himmafushi.travel and would like some information.')" label="WhatsApp" />
                <div class="service-tags">
                    @if ($business->dine_in_available)<span>Dine-in</span>@endif
                    @if ($business->takeaway_available)<span>Takeaway</span>@endif
                    @if ($business->delivery_available)<span>Delivery</span>@endif
                </div>
            </aside>
        </div>

        @if(filled($business->gallery))
            <section class="page-shell listing-gallery" aria-labelledby="business-gallery-title">
                <div><p class="eyebrow">Gallery</p><h2 id="business-gallery-title">Photos of {{ $business->name }}</h2></div>
                <div class="listing-gallery-grid">@foreach($business->gallery as $photo)<a href="{{ asset('storage/'.$photo) }}" target="_blank" rel="noopener"><img src="{{ asset('storage/'.$photo) }}" alt="{{ $business->name }} photo {{ $loop->iteration }}" loading="lazy"></a>@endforeach</div>
            </section>
        @endif

        @if ($business->latitude !== null && $business->longitude !== null)
            @php
                $coordinates = $business->latitude.','.$business->longitude;
                $directionsUrl = $business->google_maps_url ?: 'https://www.google.com/maps/search/?api=1&query='.urlencode($coordinates);
            @endphp
            <div class="page-shell business-location">
                <div class="business-location-heading"><div><p class="eyebrow">Exact location</p><h2>Find {{ $business->name }}</h2><p>{{ $business->address ?: 'Himmafushi, Maldives' }}</p></div><a class="button button-outline" href="{{ $directionsUrl }}" target="_blank" rel="noopener">Open in Google Maps</a></div>
                <div class="business-map"><iframe src="https://www.google.com/maps?q={{ urlencode($coordinates) }}&amp;z=20&amp;output=embed" title="Map showing {{ $business->name }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div>
            </div>
        @endif
    </section>
</x-layouts.app>
