<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="top:40px;">
    <div class="container-fluid justify-content-center">
        <a class="navbar-brand" href="{{ route('recipe.index') }}"><i class="fa fa-cutlery" aria-hidden="true"></i>  {{ strtoupper(config('app.name', 'Kolokas')) }}</a>
        <span class="position-absolute" style="left:200px;">
            Authentic recipes of Cyprus
        </span>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse justify-content-center collapse" id="navbarNavDropdown" style="">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('recipe.index') }}">Recipes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Events</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Contributors
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Chefs</a>
                        <a class="dropdown-item" href="#">Restaurants</a>
                    </div>
                </li>
                <li class="nav-item btn-submit-recipe">
                    <a class="nav-link" href="{{ route('recipe.create') }}"><i class="fa fa-upload" aria-hidden="true"></i> Submit Recipe</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
