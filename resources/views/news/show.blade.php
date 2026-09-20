<x-layouts.app :title="$article->seo_title ?: $article->title.' | Himmafushi News'" :description="$article->seo_description ?: $article->excerpt">
    <article class="article-page"><header class="page-hero"><div class="page-shell"><p class="eyebrow">Himmafushi journal · {{ $article->published_at->format('d F Y') }}</p><h1>{{ $article->title }}</h1><p>{{ $article->excerpt }}</p></div></header><div class="section"><div class="page-shell article-body">{!! nl2br(e($article->body)) !!}</div></div></article>
    <section class="section section-tint"><div class="page-shell"><x-site.newsletter-signup /></div></section>
</x-layouts.app>
