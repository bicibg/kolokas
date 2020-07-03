<div class="topbar no-print">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="topbar-nav topbar-left hidden-xs">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                </ul>
                <ul class="topbar-nav top-contact-info topbar-right">
                    <li>
                        <a class="login_button font-weight-bold" id="show_login" href="{{ route('recipe.create') }}">
                            <i class="fa fa-plus-square"></i> Submit Recipe
                        </a>
                    </li>
                    <li>
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
                        <li><a class="login_button" id="show_login"
                               href="{{ route('login') }}"><i
                                    class="fa fa-key"></i> Login</a></li>
                        <li><a class="login_button" id="show_signup"
                               href="{{ route('register') }}"><i
                                    class="fa fa-lock"></i> Create Account</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Logged in as {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>

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
                </ul>
            </div>
        </div>
    </div>
</div>
