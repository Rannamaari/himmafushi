@props(['title' => 'Himmafushi | Stay. Eat. Shop. Explore.', 'description' => 'Everything you need to experience Himmafushi, Maldives.'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
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
</body>
</html>
