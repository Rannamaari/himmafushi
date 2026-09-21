@php
    $experiences = [
        ['Surfing', 'World-class waves, local guidance, and boat sessions.', 'surfing'],
        ['Diving', 'Explore North Male Atoll with qualified local operators.', 'diving'],
        ['Snorkelling', 'Guided reef and lagoon experiences for your group.', 'snorkelling'],
        ['Fishing', 'Local reef fishing, private boats, and sunset sessions.', 'fishing-trips'],
        ['Excursions', 'Choose from ocean trips and memorable days on the water.', 'excursions'],
        ['Sandbank Trips', 'Private or shared escapes for swimming and relaxing.', 'sandbank-trips'],
        ['Dolphin Cruises', 'Scenic cruises through the surrounding atoll waters.', 'dolphin-cruises'],
        ['Island Life', 'Local food, island walks, shops, and everyday Himmafushi.', 'island-life'],
    ];
@endphp
<x-layouts.app title="Things To Do in Himmafushi | Book Island Experiences" description="Book surfing, diving, snorkelling, fishing, sandbank trips, dolphin cruises and local experiences in Himmafushi.">
    <section class="page-hero"><div class="page-shell"><p class="eyebrow">Island experiences</p><h1>Things To Do</h1><p>Choose an experience, see what is available, and send a direct booking enquiry for your dates.</p></div></section>
    <section class="section"><div class="page-shell"><div class="experience-link-grid">@foreach($experiences as [$name, $description, $route])<a href="{{ route($route) }}"><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><div><h2>{{ $name }}</h2><p>{{ $description }}</p></div><strong aria-hidden="true">&rarr;</strong></a>@endforeach</div></div></section>
    <section class="section section-dark"><div class="page-shell"><x-contact-cta title="Not sure what to choose?" message="Call or WhatsApp us with your dates, group size, and interests. We will help you find a suitable Himmafushi experience." /></div></section>
</x-layouts.app>
