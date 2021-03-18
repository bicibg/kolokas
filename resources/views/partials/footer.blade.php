<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <h5>{{ __('trx.about_us') }}</h5>
                <p>Nunc at augue gravida est fermentum vulputate. gravida est fermentum vulputate Pellentesque et ipsum
                    in dui malesuada tempus.</p>
            </div>
            <div class="col-lg-3 col-sm-6">
                <h5>{{ __('trx.pages') }}</h5>
                <ul class="p-0">
                    <li><a class="btn-link" href="{{ route('home') }}">{{ __('trx.home') }}</a></li>
                    <li><a class="btn-link" href="{{ route('contact.create') }}">{{ __('trx.contact_us') }}</a></li>
                    <li><a class="btn-link" href="{{ route('profile.index') }}">{{ __('trx.authors') }}</a></li>
                    <li><a class="btn-link" href="{{ route('profile.edit') }}">{{ __('trx.my_profile') }}</a></li>
                    <li>
                        <a href="#" class="btn-link disabled">{{ __('trx.restaurants') }}</a>
                        <small>{{ __('trx.coming_soon') }}</small>
                    </li>
                    <li>
                        <a href="#" class="btn-link disabled">{{ __('trx.events') }}</a>
                        <small>{{ __('trx.coming_soon') }}</small>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-sm-6">
                <h5>{{ __('trx.recipes') }}</h5>
                <ul class="p-0">
                    <li><a class="btn-link" href="{{ route('recipe.index') }}">{{ __('trx.all_recipes') }}</a></li>
                    <li><a class="btn-link" href="{{ route('recipe.my-index') }}">{{ __('trx.my_recipes') }}</a></li>
                    <li><a class="btn-link" href="{{ route('recipe.favourites') }}">{{ __('trx.my_favourites') }}</a></li>
                    <li><a class="btn-link" href="{{ route('recipe.create') }}">{{ __('trx.submit_recipe') }}</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-sm-6">
                <h5>{{ __('trx.newsletter') }}</h5>
                <form method="POST" action="{{ route('subscribe') }}">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" name="subscriber_email">
                    </div>
                    <base-button role="submit">
                        <i class="fa fa-search"></i>
                        {{ __('trx.subscribe') }}
                    </base-button>
                    <p>
                        {{ __('trx.subscribe_helper') }}
                    </p>
                </form>
            </div>
        </div>
    </div>
</footer>
