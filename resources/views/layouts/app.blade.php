<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('sub_page_title')
        Kolokas - {{ __('trx.website_title') }}
    </title>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="@yield('facebook_share_url', 'https://kolokas.com')"/>
    <meta property="og:title" content="@yield('facebook_share_title', 'Kolokas')"/>
    <meta property="og:description" content="@yield('facebook_share_description', __('trx.website_title'))"/>
    <meta property="og:image" content="@yield('facebook_share_image', asset('images/kolokas_fb.png'))"/>
    <meta property="fb:app_id" content="715933872436925"/>

    <!-- Scripts -->
@if (app()->environment('production'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-86539141-2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'UA-86539141-2');
        </script>

        <!-- Facebook Pixel Code -->
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '492864908563456');
            fbq('track', 'PageView');
            fbq('track', 'Search');
            fbq('track', 'ViewContent');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id=492864908563456&ev=PageView&noscript=1"
            /></noscript>
        <!-- End Facebook Pixel Code -->
    @endif

    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="prefetch stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="prefetch stylesheet">
    <link href="{{ mix('css/styles.css') }}" rel="prefetch stylesheet">
    <link href="{{ mix('css/styles-print.css') }}" rel="prefetch stylesheet">
    <link href="{{ mix('css/styles-480px.css') }}" rel="prefetch stylesheet">
    <link href="{{ mix('css/styles-768px.css') }}" rel="prefetch stylesheet">
    <link href="{{ mix('css/styles-992px.css') }}" rel="prefetch stylesheet">
    <link href="{{ mix('css/styles-1200px.css') }}" rel="prefetch stylesheet">

    <link href="{{ mix('css/fontawesome.css') }}" rel="prefetch stylesheet">

    @livewireStyles
</head>
<body>
<div id="print-wrapper">
</div>
<div id="app">
    <div class="sticky-top kolokas-nav">
        @include('partials.topbar')
        @include('partials.navbar')
    </div>
    <main class="pt-2 mt-xs-5 pt-xs-2">
        <flash message="{{ session('flash') ?? (session('flash-warning') ?? session('flash-error')) }}"
               type="{{ session('flash-warning') ? 'warning' : (session('flash-error') ? 'error' : '')  }}"></flash>
        @if(count($errors)>0)
            <ul class="validation-errors">
                @foreach($errors->all() as $error)
                    <li class="alert alert-danger">{{$error}}</li>
                @endforeach
            </ul>
        @endif
        @yield('content')
        @include('partials.footer')
    </main>
</div>
<script>
    window._locale = '{{ app()->getLocale() }}';
    window._translations = {!! cache('translations') !!};
</script>
@stack('scripts')

@livewireScripts
</body>
</html>
