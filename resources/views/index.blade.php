<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no,viewport-fit=cover">
    <title>{{ config('app.name') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

<meta itemprop="image" content="/images/front_page_header.jpg">
<meta itemprop="description" name="description" content="Post, sell, and buy your university textbooks from fellow students right at your university or college. It's a simple textbook exchange platform on your campus, for free!">
<meta name="keywords" content="{{ config('app.name') }},Textbooks,Trade,Students,Student,University,Buy,Sell,textbook exchange,textbook trade">
<meta name="subject" content="Trading textbooks at university">
<meta name="robots" content="index,follow">
<meta name="googlebot" content="index,follow">
<meta name="abstract" content="">
<meta name="topic" content="Textbooks on JustBookr">
<meta name="summary" content="">
<meta name="classification" content="business">
<meta name="owner" content="{{ config('app.name') }}">
<meta name="coverage" content="Worldwide">
<meta name="distribution" content="Global">

<link rel="index" href="https://justbookr.com/" title="{{ config('app.name') }}">

<!-- Prefetching, preloading, prebrowsing -->
{{-- <link rel="dns-prefetch" href="//example.com/">
<link rel="preconnect" href="https://www.example.com/">
<link rel="prefetch" href="https://www.example.com/">
<link rel="prerender" href="https://example.com/">
<link rel="preload" href="image.png"> --}}
<link rel="preconnect" href="https://www.google-analytics.com">
<link rel="preconnect" href="https://stats.pusher.com">
<link rel="preconnect" href="https://content.justbookr.com">
<link rel="preconnect" href="https://books.google.com">

<link rel="icon" type="image/png" href="/images/icons/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="/images/icons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/images/icons/android-192x192.png" sizes="192x192">

<link rel="apple-touch-icon" href="/images/icons/apple-touch-icon-120x120.png" sizes="120x120">
<link rel="apple-touch-icon" href="/images/icons/apple-touch-icon-152x152.png" sizes="152x152">
<link rel="apple-touch-icon" href="/images/icons/apple-touch-icon-167x167.png" sizes="167x167">
<link rel="apple-touch-icon" href="/images/icons/apple-touch-icon-180x180.png" sizes="180x180">

<meta name="msapplication-config" content="/browserconfig.xml">

<meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:image" content="https://justbookr.com/images/front_page_header.jpg">
<meta property="og:title" content="{{ config('app.name') }}">
<meta property="og:description" content="Trade textbooks at your uni with your Facebook account! JustBookr lets you easily find textbooks for university and post old ones for sale.">

<!-- Add to Home Screen -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">

<!-- Startup Image -->
<link rel="apple-touch-startup-image" href="/images/icons/apple-touch-startup-image-750x1334.png" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="/images/icons/apple-touch-startup-image-1125x2436.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">

<!-- Pinned Site -->
<link rel="mask-icon" href="/images/icons/mask.svg" color="#3e73b9">
<!-- Add to homescreen -->
<meta name="mobile-web-app-capable" content="yes">

<meta name="theme-color" content="#3e73b9">

<meta http-equiv="cleartype" content="on">
<meta name="skype_toolbar" content="skype_toolbar_parser_compatible">

<meta name="msapplication-TileColor" content="#3e73b9">

<link rel="dns-prefetch" href="https://stats.pusher.com">
<link rel="dns-prefetch" href="https://www.google-analytics.com">
<link rel="dns-prefetch" href="https://stats.g.doubleclick.net">
<link rel="dns-prefetch" href="https://content.justbookr.com">

  <link rel="manifest" href="/manifest.json">

  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '224430568407639');
  fbq('track', 'PageView');

 // Hotjar Tracking Code for justbookr.com
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1126144,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=224430568407639&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
</head>
<body>
	<noscript>
		You'll need to enable Javascript to get the best experience
	</noscript>
  <div id="app"></div>

  @include('scripts')
</body>
</html>
