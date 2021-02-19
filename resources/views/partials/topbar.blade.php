<nav class="navbar topbar navbar-expand navbar-light bg-light no-print d-none d-md-block py-0 px-4">
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav m-0 p-0">
            <li class="nav-item"><a href="https://www.facebook.com/kolokasrecipes" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li class="nav-item"><a href="https://www.twitter.com/kolokasrecipes" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li class="nav-item"><a href="https://www.pinterest.com/kolokasrecipes" target="_blank"><i class="fa fa-pinterest"></i></a></li>
            <li class="nav-item"><a href="https://www.instagram.com/kolokasrecipes" target="_blank"><i class="fa fa-instagram"></i></a></li>
        </ul>
        <ul class="nav navbar-nav m-0 p-0 ml-auto">
            <li class="nav-item">
                <a class="login_button font-weight-bold"
                   id="show_login"
                   href="{{ route('recipe.create') }}">
                    <i class="fa fa-plus-square"></i> {{ __('nav.submit_recipe') }}
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle"
                   href="#"
                   id="navbarDropdown"
                   role="button"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false">
                    <i class="fas fa-globe"></i>
                    {{ config()->get('app.languages')[app()->getLocale()] }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @foreach(config()->get('app.languages') as $key => $lang)
                        @if ($key !== app()->getLocale())
                            <a class="dropdown-item" href="{{ route('locale', $key) }}">
                                {{ $lang }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </li>
            @guest
                <li class="nav-item">
                    <a class="login_button" id="show_login" href="{{ route('login') }}">
                        <i class="fa fa-key"></i>
                        {{ __('auth.login') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="login_button" id="show_signup" href="{{ route('register') }}">
                        <i class="fa fa-lock"></i>
                        {{ __('auth.create_account') }}
                    </a>
                </li>
            @else
                <li class="nav-item dropdown">
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
                                                     document.getElementById('logout-form-topbar').submit();">
                            {{ __('auth.logout') }}
                        </a>
                        <form id="logout-form-topbar" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
