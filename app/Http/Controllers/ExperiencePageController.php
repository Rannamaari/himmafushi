<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ExperiencePageController extends Controller
{
    public function __invoke(string $experience): View
    {
        $experiences = [
            'surfing' => [
                'title' => 'Surfing in Himmafushi',
                'eyebrow' => 'World-class waves nearby',
                'description' => 'Plan surf sessions, local guidance, and boat access around Himmafushi for your ability and travel dates.',
                'heading' => 'Make Himmafushi your surf base',
                'intro' => 'Himmafushi is known for access to breaks around North Male Atoll. Tell our team your level, dates, and whether you need guiding, equipment, or boat transfers; we will coordinate the request and confirm the options with you.',
                'highlights' => [['Surf guidance', 'Tell us your level and we will check suitable local guidance for the conditions.'], ['Boat sessions', 'Ask us to check private or shared boat access to suitable breaks.'], ['Stay packages', 'Combine accommodation, airport transfer, and surf arrangements.']],
            ],
            'diving' => [
                'title' => 'Diving in Himmafushi',
                'eyebrow' => 'Explore North Male Atoll',
                'description' => 'Plan recreational dives and local dive experiences from Himmafushi with help from our team.',
                'heading' => 'Find the right dive plan',
                'intro' => 'Share your certification level, recent dive experience, dates, and group size. We will check suitable local options and availability, then confirm the details with you.',
                'highlights' => [['Certified divers', 'We will help check guided dives suited to certification and recent experience.'], ['Equipment options', 'We will confirm rental equipment and inclusions before booking.'], ['Private groups', 'Ask us to check tailored boat and dive arrangements for your group.']],
            ],
            'snorkelling' => [
                'title' => 'Snorkelling in Himmafushi',
                'eyebrow' => 'Discover the reef',
                'description' => 'Arrange guided snorkelling trips and lagoon experiences from Himmafushi.',
                'heading' => 'An easy way to explore the water',
                'intro' => 'Snorkelling options vary with weather, sea conditions, and group size. Tell us your preferred date and confidence level; our team will check a suitable trip and confirm it with you.',
                'highlights' => [['Reef trips', 'We will check suitable local reef areas and guidance for your trip.'], ['Equipment', 'Ask us to confirm mask, snorkel, fins, and flotation options.'], ['Family enquiries', 'We will check age guidance and private options for families.']],
            ],
            'sandbank-trips' => [
                'title' => 'Sandbank Trips from Himmafushi',
                'eyebrow' => 'A day on the lagoon',
                'description' => 'Request a private or shared sandbank escape from Himmafushi for swimming, relaxing, and photographs.',
                'heading' => 'Your own piece of the Maldives',
                'intro' => 'Sandbank visits can be arranged around suitable tides and weather. Ask about trip duration, private boats, refreshments, and combined snorkelling options.',
                'highlights' => [['Private trips', 'Arrange a boat for couples, families, or your own group.'], ['Picnic options', 'Check food, drinks, shade, and other available inclusions.'], ['Combined outings', 'Pair a sandbank visit with snorkelling or a lagoon cruise.']],
            ],
            'dolphin-cruises' => [
                'title' => 'Dolphin Cruises from Himmafushi',
                'eyebrow' => 'Cruise the atoll',
                'description' => 'Request a scenic dolphin cruise from Himmafushi, coordinated by our local team.',
                'heading' => 'A memorable trip across the water',
                'intro' => 'Departure times depend on availability and sea conditions. Wildlife sightings cannot be guaranteed, but the cruise itself is a beautiful way to experience the atoll. We will confirm the details with you before booking.',
                'highlights' => [['Shared departures', 'Ask about scheduled spaces for individuals and small groups.'], ['Private boats', 'Plan a more flexible cruise for your own party.'], ['Sunset timing', 'Check evening options for softer light and island views.']],
            ],
            'island-life' => [
                'title' => 'Experience Island Life in Himmafushi',
                'eyebrow' => 'Meet the real island',
                'description' => 'Discover Himmafushi through local food, neighbourhood walks, shops, beaches, and everyday island life.',
                'heading' => 'Spend time like a local',
                'intro' => 'Slow down and explore beyond the water. We can help you connect the places to eat, shop, walk, and experience during your stay.',
                'highlights' => [['Local food', 'Discover island restaurants, cafes, and Maldivian flavours.'], ['Walk the island', 'Find beaches, harbour views, shops, and useful services.'], ['Meet local businesses', 'Support the people and independent businesses of Himmafushi.']],
            ],
        ];

        abort_unless(isset($experiences[$experience]), 404);

        return view('experiences.show', ['experience' => $experiences[$experience]]);
    }
}
