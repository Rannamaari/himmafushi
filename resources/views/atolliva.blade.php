<x-layouts.app
    title="About Us | Atolliva Maldives Story & Vision"
    description="Learn about Atolliva Maldives and the vision behind Himmafushi.travel: thoughtful local island guidance, easier trip planning, and more visibility for island businesses."
    :image="'images/himmafushi-hero.png'"
    image-alt="Himmafushi lagoon, the first destination in the new Himmafushi.travel guide from Atolliva Maldives"
>
    @php
        $atollivaBreadcrumbs = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'About Us', 'item' => route('about')],
            ],
        ];
    @endphp
    @push('structured-data')<script type="application/ld+json">{!! json_encode($atollivaBreadcrumbs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>@endpush
    <section class="atolliva-hero">
        <img src="{{ asset('images/himmafushi-hero.png') }}" alt="The island and lagoon at Himmafushi, Maldives" fetchpriority="high">
        <div class="atolliva-hero-shade"></div>
        <div class="page-shell atolliva-hero-content">
            <p class="eyebrow light">A Maldives-based travel team</p>
            <h1>About Atolliva Maldives</h1>
            <p class="atolliva-hero-lead">Thoughtful travel begins with knowing the place. We are building Himmafushi.travel as a new destination guide to help visitors and local businesses find each other.</p>
            <div class="atolliva-hero-actions">
                <a class="button" href="https://atollivamaldives.com" target="_blank" rel="noopener">Visit AtollivaMaldives.com <span aria-hidden="true">↗</span></a>
                <a class="button button-outline-light" href="#our-vision">Our vision <span aria-hidden="true">↓</span></a>
            </div>
        </div>
    </section>

    <section class="section atolliva-intro" id="our-vision">
        <div class="page-shell atolliva-intro-grid">
            <div>
                <p class="eyebrow">A new destination project</p>
                <h2>We want local island travel to feel easier to discover and plan.</h2>
            </div>
            <div>
                <p>Atolliva Maldives helps travellers plan journeys across the Maldives. Himmafushi.travel is a new project from our team, starting with one island and a simple idea: bring useful destination information, local stays, transfers, experiences, and businesses together in one place.</p>
                <p>We are at the beginning of this journey. We will keep improving the guide, adding local stories and practical details, and making it easier for visitors to send enquiries through one helpful starting point.</p>
            </div>
        </div>
    </section>

    <section class="section atolliva-vision-section">
        <div class="page-shell">
            <div class="home-section-heading atolliva-section-heading">
                <div><p class="eyebrow">What we are working towards</p><h2>A more connected way to experience the Maldives.</h2></div>
            </div>
            <div class="atolliva-vision-list">
                <article><span>01</span><div><h3>Make local places easier to find</h3><p>Bring guesthouses, restaurants, shops, transfers, and island experiences into a practical guide visitors can use while planning.</p></div></article>
                <article><span>02</span><div><h3>Help visitors plan with confidence</h3><p>Share clear, useful information and make it simple to ask our team about dates, availability, and the details that matter.</p></div></article>
                <article><span>03</span><div><h3>Help local businesses get discovered</h3><p>Create more ways for travellers to find island businesses and send genuine enquiries to the people who serve them.</p></div></article>
                <article><span>04</span><div><h3>Grow carefully, with the community</h3><p>Start with Himmafushi, listen to visitors and local partners, and build the guide around the real character of each place.</p></div></article>
            </div>
        </div>
    </section>

    <section class="atolliva-how-section">
        <div class="page-shell">
            <p class="eyebrow light">From discovery to confirmation</p>
            <h2>One helpful place to start.</h2>
            <div class="atolliva-how-grid">
                <article><span>01</span><h3>Explore</h3><p>Browse local stays, island services, travel notes, and experiences on Himmafushi.travel.</p></article>
                <article><span>02</span><h3>Send us your plans</h3><p>Tell our team your dates, group size, and what you are looking for through a booking enquiry.</p></article>
                <article><span>03</span><h3>We coordinate and confirm</h3><p>We check the details with the relevant local provider and get back to you. Your booking is confirmed once we confirm it with you.</p></article>
            </div>
        </div>
    </section>

    <section class="section atolliva-partner-section">
        <div class="page-shell atolliva-partner-layout">
            <div><p class="eyebrow">For Himmafushi businesses</p><h2>Let’s help more travellers find you.</h2><p>We are building this destination guide with local businesses in mind. If you run a guesthouse or business in Himmafushi, talk to us about being listed and receiving visitor enquiries.</p></div>
            <div class="atolliva-partner-actions"><a class="button" href="{{ route('list-guesthouse') }}">List your guesthouse <span aria-hidden="true">→</span></a><a class="text-link" href="{{ route('partner') }}">Partner with us <span aria-hidden="true">→</span></a></div>
        </div>
    </section>

    <section class="atolliva-backlink-section">
        <div class="page-shell atolliva-backlink-inner">
            <div><p class="eyebrow light">Your Maldives, thoughtfully planned</p><h2>Discover more with Atolliva Maldives.</h2><p>Explore stays, packages, and travel planning across the Maldives on our main website.</p></div>
            <a class="button button-light" href="https://atollivamaldives.com" target="_blank" rel="noopener">Go to AtollivaMaldives.com <span aria-hidden="true">↗</span></a>
        </div>
    </section>
</x-layouts.app>
