<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kolokas') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/styles.css') }}" rel="stylesheet">
    <link href="{{ mix('css/styles-print.css') }}" rel="stylesheet">
    <link href="{{ mix('css/styles-480px.css') }}" rel="stylesheet">
    <link href="{{ mix('css/styles-768px.css') }}" rel="stylesheet">
    <link href="{{ mix('css/styles-992px.css') }}" rel="stylesheet">
    <link href="{{ mix('css/styles-1200px.css') }}" rel="stylesheet">

    <link href="{{ mix('css/fontawesome.css') }}" rel="stylesheet">

    @livewireStyles
</head>
<body>
<div id="app">
    <div class="sticky-top kolokas-nav">
        @include('partials.topbar')
        @include('partials.navbar')
    </div>
    <main class="py-2 mt-xs-5 pt-xs-2">
        <flash message="{{ session('flash') ?? (session('flash-warning') ?? session('flash-error')) }}"
               type="{{ session('flash-warning') ? 'warning' : (session('flash-error') ? 'error' : '')  }}"></flash>        @if(count($errors)>0)
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
@livewireScripts
</body>
</html>
