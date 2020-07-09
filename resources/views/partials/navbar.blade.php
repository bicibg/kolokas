<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="top:40px;" id="second">
    <div class="container-fluid justify-content-center">
        <a class="navbar-brand" href="{{ route('home') }}">
            @include('partials.svg.logo')
        </a>
        {{--        <span class="position-absolute" style="left:200px;">--}}
        {{--            {{ __('nav.Authentic recipes of Cyprus') }}--}}
        {{--        </span>--}}
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse justify-content-center collapse" id="navbarNavDropdown" style="">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="{{ route('recipe.index') }}"
                       data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        Recipes
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('recipe.index') }}">All Recipes</a>
                        <div class="dropdown-divider"></div>
                        @foreach(\App\Models\Category::all() as $category)
                            <a class="dropdown-item"
                               href="{{ route('recipe.index') . '?c=' . $category->id }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </li>
                {{--                <li class="nav-item">--}}
                {{--                    <a class="nav-link" href="{{ route('recipe.index') }}">Recipes</a>--}}
                {{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="#">Authors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">
                        <div>Restaurants</div>
                        <small class="position-absolute" style="margin-top: -6px;">Coming soon</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">
                        <div>Events</div>
                        <small class="position-absolute" style="margin-top: -6px;">Coming soon</small>
                    </a>
                </li>

                <li class="nav-item d-md-none">
                    <a class="nav-link login_button font-weight-bold"
                       id="show_login"
                       href="{{ route('recipe.create') }}">
                        <i class="fa fa-plus-square"></i> Submit Recipe
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
                    <li class="nav-item d-md-none"><a class="nav-link login_button" id="show_login"
                                                      href="{{ route('login') }}"><i
                                class="fa fa-key"></i> Login</a></li>
                    <li class="nav-item d-md-none"><a class="nav-link login_button" id="show_signup"
                                                      href="{{ route('register') }}"><i
                                class="fa fa-lock"></i> Create Account</a></li>
                @else
                    <li class="nav-item dropdown d-md-none">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Logged in as {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
                            <a class="dropdown-item" href="{{ route('recipe.my-index') }}">My Recipes</a>
                            <a class="dropdown-item" href="{{ route('recipe.favourites') }}">My Favourites</a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                {{--<li class="nav-item">
                    <a class="nav-link" href="#">Events</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        Authors
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Chefs</a>
                        <a class="dropdown-item" href="#">Restaurants</a>
                    </div>
                </li>--}}
            </ul>
        </div>
    </div>
</nav>
