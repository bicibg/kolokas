<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kolokas - {{ __('trx.website_title') }}</title>
    <meta property="og:type" content="article" />
    <meta property="og:url" content="@yield('facebook_share_url', 'https://kolokas.com')" />
    <meta property="og:title" content="@yield('facebook_share_title', 'Kolokas')" />
    <meta property="og:description" content="@yield('facebook_share_description', __('trx.website_title'))" />
    <meta property="og:image" content="@yield('facebook_share_image', asset('images/kolokas_fb.png'))" />
    <meta property="fb:app_id" content="715933872436925" />

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
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent shadow-none fixed-top mt-3" id="second">
        <div class="container-fluid justify-content-end">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="fas fa-globe"></i>
                {{ config()->get('app.languages')[app()->getLocale()] }}
                <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                @foreach(config()->get('app.languages') as $key => $lang)
                    @if ($key !== app()->getLocale())
                        <a class="dropdown-item" href="{{ route('locale', $key) }}">{{ $lang }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </nav>

    <main class="py-2 mt-xs-5 pt-xs-2">
        <flash message="{{ session('flash') ?? (session('flash-warning') ?? session('flash-error')) }}"
               type="{{ session('flash-warning') ? 'warning' : (session('flash-error') ? 'error' : '')  }}"></flash>

        <div class="container text-center">
            <a class="navbar-brand navbar-brand-demo mb-5 mt-5 " href="{{ route('home') }}">
                @include('partials.svg.logo_' . app()->getLocale())
            </a>
            <form action="{{ route('demo.enable') }}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-7 col-sm-12 text-center border-bottom">
                        <h3 class="section-title">{{ __('trx.demo.no_access') }}</h3>
                    </div>

                    <div class="col-md-7 col-sm-12 text-center mt-2 mb-2">
                        <h5 class="section-title">{!! __('trx.demo.contact') !!}</h5>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="key"><i class="fa fa-key"></i></span>
                            </div>
                            <input type="text"
                                   class="form-control"
                                   placeholder="{{ __('trx.demo.access_key') }}"
                                   aria-label="{{ __('trx.demo.access_key') }}"
                                   aria-describedby="key"
                                   name="demo-key">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <base-button :role="'submit'">
                            {{ __('trx.demo.letmein') }}
                        </base-button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
<script>
    window._locale = '{{ app()->getLocale() }}';
    window._translations = {!! cache('translations') !!};
</script>
@stack('scripts')
</body>
</html>
