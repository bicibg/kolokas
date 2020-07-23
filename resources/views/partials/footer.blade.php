<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <h5>{{ __('nav.about') }}</h5>
                <p>Nunc at augue gravida est fermentum vulputate. gravida est fermentum vulputate Pellentesque et ipsum
                    in dui malesuada tempus.</p>
            </div>
            <div class="col-lg-3 col-sm-6">
                <h5>{{ __('nav.pages') }}</h5>
                <ul class="p-0">
                    <li><a class="btn-link" href="{{ route('home') }}">{{ __('nav.home') }}</a></li>
                    <li><a class="btn-link" href="{{ route('contact.create') }}">{{ __('nav.contact_us') }}</a></li>
                    <li><a class="btn-link" href="{{ route('profile.index') }}">{{ __('nav.authors') }}</a></li>
                    <li><a class="btn-link" href="{{ route('profile.edit') }}">{{ __('nav.my_profile') }}</a></li>
                    <li>
                        <a href="#" class="btn-link disabled">{{ __('nav.restaurants') }}</a>
                        <small>{{ __('general.coming_soon') }}</small>
                    </li>
                    <li>
                        <a href="#" class="btn-link disabled">{{ __('nav.events') }}</a>
                        <small>{{ __('general.coming_soon') }}</small>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-sm-6">
                <h5>{{ __('nav.recipes') }}</h5>
                <ul class="p-0">
                    <li><a class="btn-link" href="{{ route('recipe.index') }}">{{ __('nav.all_recipes') }}</a></li>
                    <li><a class="btn-link" href="{{ route('recipe.my-index') }}">{{ __('nav.my_recipes') }}</a></li>
                    <li><a class="btn-link" href="{{ route('recipe.favourites') }}">{{ __('nav.my_favourites') }}</a></li>
                    <li><a class="btn-link" href="{{ route('recipe.create') }}">{{ __('nav.submit_recipe') }}</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-sm-6">
                <h5>{{ __('nav.newsletter') }}</h5>
                <form method="POST" action="{{ route('subscribe') }}">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" name="subscriber_email">
                    </div>
                    <base-button role="submit">
                        <i class="fa fa-search"></i>
                        {{ __('general.subscribe') }}
                    </base-button>
                    <p>
                        {{ __('general.subscribe_text') }}
                    </p>
                </form>
            </div>
        </div>
    </div>
</footer>