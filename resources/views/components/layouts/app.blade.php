@props(['title' => 'Himmafushi | Stay. Eat. Shop. Explore.', 'description' => 'Everything you need to experience Himmafushi, Maldives.'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="site-body">
    <x-site.header />
    <main>{{ $slot }}</main>
    <x-site.footer />
</body>
</html>
