@props([
    'title' => 'Himmafushi, Maldives | Stays, Transfers, Food & Island Guide',
    'description' => 'Plan your Himmafushi visit with local guesthouses, speedboat transfers, restaurants, activities, shops, deals and practical island guides.',
    'image' => null,
    'imageAlt' => null,
    'canonical' => null,
    'robots' => 'index,follow,max-image-preview:large',
    'type' => 'website',
])
@php
    $canonicalUrl = $canonical ?: url()->current();
    $socialImageAlt = $imageAlt ?: 'Discover Himmafushi, Maldives';
    $websiteSchema = [
        '@context' => 'https://schema.org', '@type' => 'WebSite', 'name' => 'Himmafushi',
        'url' => route('home'), 'description' => $description,
        'potentialAction' => ['@type' => 'SearchAction', 'target' => route('search').'?q={search_term_string}', 'query-input' => 'required name=search_term_string'],
    ];
@endphp
@php
    $socialImagePath = null;
    if ($image && preg_match('/^https?:\/\//i', $image)) {
        $socialImage = $image;
    } else {
        $relativeImage = ltrim($image ?: 'images/himmafushi-hero.png', '/');
        $imageIsPublic = str_starts_with($relativeImage, 'images/');
        $socialImage = asset($imageIsPublic ? $relativeImage : 'storage/'.$relativeImage);
        $socialImagePath = public_path($imageIsPublic ? $relativeImage : 'storage/'.$relativeImage);
    }
    $socialImageSize = $socialImagePath && is_file($socialImagePath) ? getimagesize($socialImagePath) : false;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="robots" content="{{ $robots }}">
    <meta name="theme-color" content="#17383c">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon-64.png') }}" type="image/png" sizes="64x64">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:type" content="{{ $type }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:site_name" content="Himmafushi">
    <meta property="og:locale" content="en_US">
    <meta property="og:image" content="{{ $socialImage }}">
    <meta property="og:image:secure_url" content="{{ $socialImage }}">
    <meta property="og:image:alt" content="{{ $socialImageAlt }}">
    @if($socialImageSize)<meta property="og:image:type" content="{{ $socialImageSize['mime'] }}"><meta property="og:image:width" content="{{ $socialImageSize[0] }}"><meta property="og:image:height" content="{{ $socialImageSize[1] }}">@endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $socialImage }}">
    <meta name="twitter:image:alt" content="{{ $socialImageAlt }}">
    @stack('head-meta')
    <script type="application/ld+json">{!! json_encode($websiteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @stack('structured-data')
    @if($googleAnalyticsId = $marketingSettings->get('google_analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ urlencode($googleAnalyticsId) }}"></script>
        <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());gtag('config',@js($googleAnalyticsId));</script>
    @endif
    @if($googleTagManagerId = $marketingSettings->get('google_tag_manager_id'))
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f)})(window,document,'script','dataLayer',@js($googleTagManagerId));</script>
    @endif
    @if($adsensePublisherId = $marketingSettings->get('adsense_publisher_id'))
        <script async crossorigin="anonymous" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ urlencode($adsensePublisherId) }}"></script>
    @endif
    <x-ad-slot position="site_head" head />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="site-body">
    @if($googleTagManagerId = $marketingSettings->get('google_tag_manager_id'))<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ urlencode($googleTagManagerId) }}" height="0" width="0" class="tracking-frame" title="Google Tag Manager"></iframe></noscript>@endif
    <x-site.header />
    <main>{{ $slot }}</main>
    <div class="page-shell sitewide-ad"><x-ad-slot position="site_after_content" /></div>
    <x-site.footer />
    <x-site.newsletter-popup />
</body>
</html>
