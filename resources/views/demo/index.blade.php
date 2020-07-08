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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">
    @livewireStyles
</head>
<body>
<div id="app">
    <main class="py-2">
        <flash message="{{ session('flash') }}"></flash>
        <flash message="{{ session('flash-error') }}" type="error"></flash>

        <div class="container text-center">
            <a class="navbar-brand h-100" href="{{ route('home') }}" style="height:120%">
                {{--            <i class="fa fa-cutlery" aria-hidden="true"></i>--}}
                {{--            {{ strtoupper(config('app.name', 'Kolokas')) }}--}}
                <img src="{{ asset('storage/images/generic/logo.png') }}" class="h-100">
            </a>
            <form action="{{ route('demo.enable') }}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-7 col-sm-12 text-center border-bottom">
                        <h3 class="section-title">Kolokas.com is currently accessible by invite only for testing
                            purposes. If you don't have an access key, check back later when we are live.</h3>
                    </div>

                    <div class="col-md-7 col-sm-12 text-center mt-2 mb-2">
                        <h5 class="section-title">If you don't have an access key but would like to help testing
                            Kolokas.com before it goes live, you can contact me on
                            <a href="mailto:bugraergin@gmail.com" target="_blank">bugraergin@gmail.com</a></h5>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="key"><i class="fa fa-key"></i></span>
                            </div>
                            <input type="text"
                                   class="form-control"
                                   placeholder="Demo access key"
                                   aria-label="Demo access key"
                                   aria-describedby="key"
                                   name="demo-key">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <base-button :role="'submit'">
                            Let me in
                        </base-button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
@livewireScripts
</body>
</html>
