<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('sub_page_title')Kolokas - {{ __('trx.website_title') }}</title>
    <meta name="description" content="@yield('meta_description', __('trx.website_title'))">
    <link rel="canonical" href="{{ url()->current() }}">
    @foreach(config('app.languages') as $langCode => $langName)
        <link rel="alternate" hreflang="{{ $langCode }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($langCode, null, [], true) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL('en', null, [], true) }}">

    <!-- Open Graph -->
    <meta property="og:type" content="@yield('og_type', 'website')"/>
    <meta property="og:url" content="@yield('og_url', url()->current())"/>
    <meta property="og:title" content="@yield('og_title', 'Kolokas - ' . __('trx.website_title'))"/>
    <meta property="og:description" content="@yield('og_description', __('trx.website_title'))"/>
    <meta property="og:image" content="@yield('og_image', asset('images/kolokas_fb.png'))"/>
    <meta property="og:locale" content="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleRegional() }}"/>
    <meta property="og:site_name" content="Kolokas"/>
    <meta property="fb:app_id" content="715933872436925"/>

    <!-- Twitter Card -->
    <meta name="twitter:card" content="@yield('twitter_card', 'summary')">
    <meta name="twitter:title" content="@yield('og_title', 'Kolokas - ' . __('trx.website_title'))">
    <meta name="twitter:description" content="@yield('og_description', __('trx.website_title'))">
    <meta name="twitter:image" content="@yield('og_image', asset('images/kolokas_fb.png'))">

    <!-- Scripts -->
@if (app()->environment('production'))
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
        </script>
        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id=492864908563456&ev=PageView&noscript=1"
            /></noscript>
        <!-- End Facebook Pixel Code -->
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    @vite([
        'resources/js/app.js',
        'resources/sass/app.scss',
        'resources/sass/styles.scss',
        'resources/sass/styles-print.scss',
    ])

    <style>[x-cloak] { display: none !important; }</style>
    @livewireStyles
    @stack('schema')
</head>
<body>
<div id="print-wrapper">
</div>
<div id="app">
    <a href="#main-content" class="visually-hidden visually-hidden-focusable">{{ __('trx.skip_to_content') ?? 'Skip to content' }}</a>
    <div class="sticky-top kolokas-nav">
        @include('partials.topbar')
        @include('partials.navbar')
    </div>
    <main id="main-content" class="pt-2 mt-xs-5 pt-xs-2">
        <div x-data="flashMessage"
             x-on:flash.window="flash($event.detail)"
             x-show="show"
             x-transition
             x-cloak
             :class="'alert alert-flash fade show ' + alertClass"
             role="alert"
             data-initial-message="{{ session('flash') ?? (session('flash-warning') ?? session('flash-error') ?? '') }}"
             data-initial-type="{{ session('flash-warning') ? 'warning' : (session('flash-error') ? 'error' : 'success') }}">
            <div class="row">
                <div class="col-10">
                    <strong x-text="prefix"></strong>
                    <span x-text="body"></span>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-inline" @click="hide()">X</button>
                </div>
            </div>
        </div>
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
    window._translations = {{ Js::from(cache('translations')) }};
</script>
@stack('scripts')

@livewireScripts
</body>
</html>
