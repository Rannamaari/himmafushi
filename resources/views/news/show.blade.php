@push('structured-data')
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org', '@type' => 'Article', 'headline' => $article->title,
    'description' => $article->seo_description ?: $article->excerpt, 'image' => $article->image ? asset('storage/'.$article->image) : asset('images/himmafushi-hero.png'),
    'datePublished' => $article->published_at?->toAtomString(), 'dateModified' => $article->updated_at?->toAtomString(),
    'mainEntityOfPage' => route('news.show', $article), 'articleSection' => $article->category?->name,
    'publisher' => ['@type' => 'Organization', 'name' => 'Himmafushi', 'url' => route('home')],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
<x-layouts.app :title="$article->seo_title ?: $article->title.' | Himmafushi News'" :description="$article->seo_description ?: $article->excerpt" :image="$article->image" type="article">
    <article class="article-page"><header class="page-hero"><div class="page-shell"><p class="eyebrow">{{ $article->category?->name ?: 'Himmafushi journal' }} · {{ $article->published_at->format('d F Y') }}</p><h1>{{ $article->title }}</h1><p>{{ $article->excerpt }}</p></div></header><div class="section"><div class="page-shell article-body">{{ $article->renderedBody() }}</div><div class="page-shell article-after-ad"><x-ad-slot position="blog_after_content" /></div></div></article>
    <section class="section section-tint"><div class="page-shell"><x-site.newsletter-signup /></div></section>
</x-layouts.app>
