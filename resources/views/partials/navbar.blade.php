<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="top:40px;">
    <div class="container-fluid justify-content-center">
        <a class="navbar-brand h-100" href="{{ route('home') }}" style="height:120%">
            <img src="{{ asset('storage/images/generic/logo.png') }}" class="h-100">
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
