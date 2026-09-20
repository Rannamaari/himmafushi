<x-layouts.app title="Himmafushi News & Island Guides" description="News, practical travel guides and island updates from Himmafushi, Maldives.">
    <section class="page-hero"><div class="page-shell"><p class="eyebrow">Island journal</p><h1>News from Himmafushi</h1><p>Practical local guides, travel updates and stories to help you plan a better island stay.</p></div></section>
    <section class="section"><div class="page-shell">
        @if($featuredArticle)<article class="featured-article"><div><p class="eyebrow">Featured guide</p><h2>{{ $featuredArticle->title }}</h2><p>{{ $featuredArticle->excerpt }}</p><a class="button" href="{{ route('news.show', $featuredArticle) }}">Read guide</a></div></article>@endif
        <div class="section-row news-heading"><x-section-heading eyebrow="Latest stories" title="Read, plan, explore" description="Fresh island notes and useful updates from Himmafushi."/></div>
        <div class="card-grid news-grid">@forelse($articles as $article)<article class="listing-card news-card"><div class="listing-image"><span>Himmafushi journal</span></div><div class="listing-body"><p class="eyebrow">{{ $article->published_at->format('d M Y') }}</p><h2>{{ $article->title }}</h2><p>{{ $article->excerpt }}</p><a class="text-link" href="{{ route('news.show', $article) }}">Read article</a></div></article>@empty<x-empty-state title="Stories are on the way" message="New Himmafushi guides and updates will appear here." />@endforelse</div>
        <div class="pagination">{{ $articles->links() }}</div>
    </div></section>
    <section class="section section-dark"><div class="page-shell"><x-site.newsletter-signup compact /></div></section>
</x-layouts.app>
