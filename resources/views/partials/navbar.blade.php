<nav class="navbar navbar-main bg-white navbar-expand-lg navbar-light py-2">
    <a class="navbar-brand d-block h-100 position-absolute mx-5" href="{{ route('home') }}">
        @include('partials.svg.logo_' . app()->getLocale())
    </a>
    <button class="navbar-toggler ml-auto"
            type="button"
            onclick="lockScroll();"
            data-toggle="collapse"
            data-target="#navbarResponsive"
            aria-controls="navbarResponsive"
            aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto ml-auto mt-2 d-md-none">
            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('recipe.index') }}"
                >
                    {{ __('nav.recipes') }}
                </a>
            </li>
            <li class="nav-item dropdown menu-large d-none d-md-block">
                <a class="nav-link dropdown-toggle"
                   href="{{ route('recipe.index') }}"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false">
                    {{ __('nav.recipes') }}
                </a>

                <div class="dropdown-menu megamenu text-center">
                    <div class="row text-left m-row justify-content-between">
                        <div class="col-md-2">
                            <a class="d-inline d-flex dropdown-item"
                               href="{{ route('recipe.index') }}">{{ __('nav.all_recipes') }}</a>
                            <div class="dropdown-divider"></div>
                        </div>
                    </div>
                    <div class="row text-left m-row justify-content-between">
                        @foreach($categories->chunk(5) as $group)
                            <div class="col-md-2">
                                @foreach($group as $category)
                                    <a class="d-inline d-flex dropdown-item"
                                       href="{{ route('recipe.index') . '?c=' . $category->id }}">{{ $category->name }}</a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.index') }}">{{ __('nav.authors') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">
                    {{ __('nav.restaurants') }}
                    <small class="position-absolute" style="margin-top: -6px;">{{ __('general.coming_soon') }}</small>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">
                    {{ __('nav.events') }}
                    <small class="position-absolute" style="margin-top: -6px;">{{ __('general.coming_soon') }}</small>
                </a>
            </li>
            <li class="nav-item d-md-none">
                <div class="dropdown-divider"></div>
            </li>
            <li class="nav-item d-md-none">
                <a class="nav-link login_button font-weight-bold"
                   id="show_login"
                   href="{{ route('recipe.create') }}">
                    <i class="fa fa-plus-square"></i> {{ __('nav.submit_recipe') }}
                </a>
            </li>
            <li class="nav-item d-md-none">
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
            </li>
            <li class="nav-item d-md-none">
                <div class="dropdown-divider"></div>
            </li>
            @guest
                <li class="nav-item d-md-none">
                    <a class="nav-link login_button" id="show_login" href="{{ route('login') }}">
                        <i class="fa fa-key"></i>
                        {{ __('auth.login') }}
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link login_button" id="show_signup" href="{{ route('register') }}">
                        <i class="fa fa-lock"></i>
                        {{ __('auth.create_account') }}
                    </a>
                </li>
            @else
                <li class="nav-item d-md-none">
                    <h6 class="dropdown-header">
                        {{ __('auth.logged_in_as', ['name' => Auth::user()->name]) }}
                    </h6>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link" href="{{ route('profile.edit') }}">
                        <i class="fa fa-user"></i>
                        {{ __('nav.my_profile') }}
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link" href="{{ route('recipe.my-index') }}">
                        <i class="fa fa-cutlery"></i>
                        {{ __('nav.my_recipes') }}
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link" href="{{ route('recipe.favourites') }}">
                        <i class="fa fa-heart-o"></i>
                        {{ __('nav.my_favourites') }}
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a
                        class="nav-link"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >
                        <i class="fa fa-sign-out"></i>
                        {{ __('auth.logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>