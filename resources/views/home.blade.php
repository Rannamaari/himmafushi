<x-layouts.app title="Himmafushi | Stay. Eat. Shop. Explore." description="Discover stays, experiences, transfers, food and local stories from Himmafushi, Maldives.">
    <section class="hero home-hero" style="background-image: linear-gradient(90deg, rgba(6, 31, 38, .8), rgba(6, 31, 38, .12)), url('{{ asset('images/himmafushi-hero.png') }}')">
        <div class="page-shell hero-content">
            <p class="eyebrow light">Maldives, made local</p>
            <h1>HIMMAFUSHI</h1>
            <p class="hero-tagline">Stay. Eat. Shop. Explore.</p>
            <p class="hero-copy">Your local guide to island stays, ocean adventures and the easiest way to get here.</p>
            <div class="hero-actions"><a class="button button-light" href="#discover">Discover the island</a><a class="button button-outline-light" href="{{ route('transfers.index') }}">Plan your transfer</a></div>
        </div>
    </section>

    <section id="discover" class="home-search-section">
        <div class="page-shell home-search-wrap">
            <form class="home-search" method="GET" action="{{ route('search') }}">
                <label for="home-search-input">What are you looking for in Himmafushi?</label>
                <div><input id="home-search-input" name="q" placeholder="Search stays, food, shops, activities and more" required><button class="button" type="submit">Search</button></div>
            </form>
            <x-ad-slot position="home_search_sponsor" compact />
        </div>
    </section>

    @if($featuredSection && $featuredItems->isNotEmpty())
        <section class="home-section featured-bento-section" aria-labelledby="featured-heading">
            <div class="page-shell home-section-heading"><div>@if($featuredSection->eyebrow)<p class="eyebrow">{{ $featuredSection->eyebrow }}</p>@endif<h2 id="featured-heading">{{ $featuredSection->title }}</h2>@if($featuredSection->description)<p>{{ $featuredSection->description }}</p>@endif</div>@if($featuredSection->cta_label && $featuredSection->cta_url)<a class="text-link" href="{{ $featuredSection->cta_url }}">{{ $featuredSection->cta_label }}</a>@endif</div>
            <div class="page-shell featured-bento" aria-label="Featured places and experiences">
                @foreach($featuredItems->take(7) as $item)
                    <article class="featured-bento-item featured-bento-item-{{ $loop->iteration }}">
                        <a href="{{ $item->url ?: '#' }}">
                            <img src="{{ $item->image ? asset('storage/'.$item->image) : asset('images/himmafushi-hero.png') }}" alt="{{ $item->title }}" width="900" height="700" loading="lazy">
                            @if($item->badge)<span class="feature-badge">{{ $item->badge }}</span>@endif
                            <div class="featured-bento-content">@if($item->type_label)<p>{{ $item->type_label }}</p>@endif<h3>{{ $item->title }}</h3>@if($item->summary)<span>{{ str($item->summary)->limit(90) }}</span>@endif<div><strong>{{ $item->price_text ?: 'Discover locally' }}</strong><span>{{ $item->cta_label ?: 'View' }} →</span></div></div>
                        </a>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <div class="page-shell home-inline-ad"><x-ad-slot position="home_after_featured" /></div>

    <section class="home-section travel-section" aria-labelledby="travel-heading">
        <div class="page-shell travel-layout">
            <div class="travel-intro"><p class="eyebrow light">Arrive with confidence</p><h2 id="travel-heading">Getting to Himmafushi</h2><p>Himmafushi is reached by sea from Velana International Airport and Male. Choose your travel date to see the services running that day.</p><a class="button" href="{{ route('transfers.index') }}">Book Your Transfer <span aria-hidden="true">→</span></a></div>
            <div class="travel-options">
                @forelse($transfers->take(3) as $transfer)
                    <article class="travel-option"><span>{{ $loop->iteration < 10 ? '0'.$loop->iteration : $loop->iteration }}</span><div><p>{{ str_replace('_', ' ', $transfer->type ?: 'Speedboat transfer') }}</p><h3>{{ $transfer->from_location }} <span aria-hidden="true">→</span> {{ $transfer->to_location }}</h3><dl><div><dt>Departure</dt><dd>{{ $transfer->departure_time?->format('H:i') ?: 'On request' }}</dd></div><div><dt>Travel time</dt><dd>{{ $transfer->duration_minutes ? $transfer->duration_minutes.' min' : 'Confirm when booking' }}</dd></div></dl>@if($transfer->tourist_price)<strong>Guest fare {{ $transfer->tourist_currency }} {{ number_format($transfer->tourist_price, 0) }}</strong>@endif</div></article>
                @empty
                    <article class="travel-option"><span>01</span><div><p>Travel planning</p><h3>Airport and Male transfers</h3><p>Choose your travel date to request the next available service.</p></div></article>
                @endforelse
            </div>
        </div>
    </section>

    @if($guesthouses->isNotEmpty())
        <section class="home-section stays-section" aria-labelledby="stays-heading">
            <div class="page-shell home-section-heading"><div><p class="eyebrow">Sleep close to the sea</p><h2 id="stays-heading">Featured Guesthouses in Himmafushi</h2><p>Locally hosted stays selected for more visibility, rotated fairly within each placement level.</p></div><a class="text-link" href="{{ route('guesthouses.index') }}">View all guesthouses</a></div>
            <div class="page-shell stay-carousel">
                @foreach($guesthouses as $guesthouse)
                    <article class="stay-card">
                        <a class="stay-card-image" href="{{ route('guesthouses.show', $guesthouse) }}"><img src="{{ $guesthouse->image ? asset('storage/'.$guesthouse->image) : asset('images/himmafushi-hero.png') }}" alt="{{ $guesthouse->name }} in Himmafushi" width="720" height="520" loading="lazy"><span class="feature-badge">Featured stay</span></a>
                        <div class="stay-card-body"><p>{{ $guesthouse->address ?: 'Himmafushi, Maldives' }}</p><h3>{{ $guesthouse->name }}</h3><span>{{ str($guesthouse->excerpt ?: strip_tags($guesthouse->description ?: '') ?: 'A locally hosted island stay with direct booking requests.')->limit(105) }}</span><div class="stay-card-rate">@if($guesthouse->tourist_rate_from)<strong>From USD {{ number_format($guesthouse->tourist_rate_from, 0) }}</strong>@elseif($guesthouse->local_rate_from)<strong>From MVR {{ number_format($guesthouse->local_rate_from, 0) }}</strong>@else<strong>Request best rate</strong>@endif</div><div class="stay-card-actions"><a class="text-link card-primary-link" href="{{ route('guesthouses.show', $guesthouse) }}" aria-label="View {{ $guesthouse->name }}">View Stay</a><a class="button button-small card-secondary-action" href="{{ route('guesthouses.request', $guesthouse) }}">Request / Book</a></div></div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if($articles->isNotEmpty())
        <section class="home-section stories-section" aria-labelledby="stories-heading">
            <div class="page-shell home-section-heading"><div><p class="eyebrow">Island notes</p><h2 id="stories-heading">Discover Himmafushi</h2><p>Recent guides and stories to help you travel thoughtfully and make more of your stay.</p></div><a class="text-link" href="{{ route('news.index') }}">Read all stories</a></div>
            <div class="page-shell story-grid">
                @foreach($articles as $article)
                    <article class="story-card"><a class="story-card-image" href="{{ route('news.show', $article) }}"><img src="{{ $article->image ? asset('storage/'.$article->image) : asset('images/himmafushi-hero.png') }}" alt="{{ $article->title }}" width="720" height="480" loading="lazy"></a><div><p>Himmafushi guide · {{ $article->published_at->format('j M Y') }}</p><h3><a href="{{ route('news.show', $article) }}">{{ $article->title }}</a></h3><span>{{ str($article->excerpt)->limit(125) }}</span><a class="text-link card-primary-link" href="{{ route('news.show', $article) }}" aria-label="Read {{ $article->title }}">Read More</a></div></article>
                @endforeach
            </div>
        </section>
    @endif

    <section class="home-ad-section"><div class="page-shell"><x-ad-slot position="home_after_blog" /></div></section>

</x-layouts.app>
