<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>News5</title>
<meta name="title" content="@yield('meta_title')">
<meta name="description" content="@yield('meta_description')">
<meta name="keywords" content="@yield('meta_keywords')">
<meta name="author" content="@yield('author')">
<meta name="theme-color" content="#2757fd">
@if (request()->is('/'))
    <link rel="canonical" href="https://bigtimesnews.com/" />
@else
    <link rel="canonical" href="{{ url()->current() }}" />
@endif
<meta name="robots" content="index, follow">

<!-- Open Graph Tags -->
<meta property="og:locale" content="en_US">
<meta property="og:type" content="website">
<meta property="og:title" content="@yield('meta_title')" />
<meta property="og:description" content="@yield('meta_description')" />
@if (request()->is('/'))
    <meta property="og:url" content="https://siteffects.com/" />
@else
    <meta property="og:url" content="{{ url()->current() }}" />
@endif
<meta property="og:site_name" content="{{ \App\Helpers\Helper::getCompanyName() }}">
<meta property="og:image" content="{{ url('assets/img/social-og.png') }}">
<meta property="og:image:width" content="1180">
<meta property="og:image:height" content="600">
<meta property="og:image:type" content="image/png">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('meta_title')">
<meta name="twitter:description" content="@yield('meta_description')">
<meta name="twitter:image" content="{{ url('assets/img/social-og.png') }}">

<!-- Favicon -->
<link rel="icon" href="{{ url('favicons/favicon.ico') }}" />
<link rel="icon" type="image/png" href="{{ url('favicons/favicon-96x96.png') }}" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="{{ url('favicons/favicon.svg') }}" />
<link rel="shortcut icon" href="{{ url('favicons/favicon.ico') }}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ url('favicons/apple-touch-icon.png') }}" />
<link rel="manifest" href="{{ url('favicons/site.webmanifest') }}" />