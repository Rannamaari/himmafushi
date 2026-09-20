<x-layouts.app :title="$search ? 'Search results for '.$search.' | Himmafushi' : 'Search Himmafushi'" description="Search guesthouses, restaurants, shops, experiences, transfers, deals and island news in Himmafushi.">
    <section class="page-hero search-page-hero">
        <div class="page-shell">
            <p class="eyebrow">Discover Himmafushi</p>
            <h1>Search the island</h1>
            <form class="directory-search" method="GET" action="{{ route('search') }}">
                <label for="search-page-input">What are you looking for?</label>
                <div><input id="search-page-input" name="q" value="{{ $search }}" placeholder="Try Wave, food, surf or airport" autofocus><button class="button" type="submit">Search</button></div>
            </form>
        </div>
    </section>

    <section class="section search-results-section">
        <div class="page-shell">
            @if($search === '')
                <x-empty-state title="Start your search" message="Search stays, restaurants, shops, island activities, transfers, deals, and local news." />
            @elseif($results->isEmpty())
                <x-empty-state :title="'No results found for '.$search" message="Try a different word, or browse one of the island categories below." />
            @else
                <div class="search-results-heading">
                    <p class="eyebrow">Search results</p>
                    <h2>{{ $results->count() }} {{ str('result')->plural($results->count()) }} for “{{ $search }}”</h2>
                </div>
                <div class="search-result-list">
                    @foreach($results as $result)
                        <a class="search-result-item" href="{{ $result['url'] }}">
                            <span class="search-result-type">{{ $result['type'] }}</span>
                            <span class="search-result-content"><strong>{{ $result['title'] }}</strong><span>{{ str($result['summary'])->limit(190) }}</span></span>
                            <span class="search-result-arrow" aria-hidden="true">→</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
