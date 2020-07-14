<nav class="navbar navbar-main bg-white navbar-expand-lg navbar-light py-2">
    <a class="navbar-brand d-block h-100 position-absolute mx-5" href="{{ route('home') }}">
        @include('partials.svg.logo_' . app()->getLocale())
    </a>
    <button class="navbar-toggler ml-auto"
            type="button"
            data-toggle="collapse"
            data-target="#navbarResponsive"
            aria-controls="navbarResponsive"
            aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle"
                   href="{{ route('recipe.index') }}"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false">
                    {{ __('nav.recipes') }}
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('recipe.index') }}">{{ __('nav.all_recipes') }}</a>
                    <div class="dropdown-divider"></div>
                    @foreach(\App\Models\Category::all() as $category)
                        <a class="dropdown-item"
                           href="{{ route('recipe.index') . '?c=' . $category->id }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">{{ __('nav.authors') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">
                    <div>{{ __('restaurants') }}</div>
                    <small class="position-absolute" style="margin-top: -6px;">{{ __('general.coming_soon') }}</small>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">
                    <div>{{ __('nav.events') }}</div>
                    <small class="position-absolute" style="margin-top: -6px;">{{ __('general.coming_soon') }}</small>
                </a>
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
                <li class="nav-item dropdown d-md-none">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ __('auth.logged_in_as', ['name' => Auth::user()->name]) }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('nav.my_profile') }}</a>
                        <a class="dropdown-item" href="{{ route('recipe.my-index') }}">{{ __('nav.my_recipes') }}</a>
                        <a class="dropdown-item" href="{{ route('recipe.favourites') }}">{{ __('nav.my_favourites') }}</a>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('auth.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>