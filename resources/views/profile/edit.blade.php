@extends('layouts.app')

@section('content')
    <div class="container kolokas-form mt-5">

        <div class="row justify-content-center kolokas-form">
            <div class="col-sm-12 col-md-8">
                <div class="header text-left">
                    <h2>{{ __('trx.account') }}</h2>
                    <hr>
                </div>
            </div>
            <div class="col-md-12">
                <form method="POST" action="{{ route('password.new') }}">
                    @csrf
                    <div class="justify-content-center form-row">
                        <div class="col-xs-12 col-md-8">
                            <fieldset>
                                <div class="row">
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label for="email">{{ __('trx.email') }}</label>
                                        <input class="form-control-plaintext"
                                               readonly
                                               id="email"
                                               value="{{ auth()->user()->email }}">
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12">
                                        <label for="current_password">{{ __('trx.passwords.current_password') }}
                                            * </label>
                                        <input class="form-control input-lg"
                                               name="current_password"
                                               type="password"
                                               id="current_password">
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12">
                                        <label for="new_password">{{ __('trx.passwords.new_password') }} *</label>
                                        <input class="form-control input-lg"
                                               name="new_password"
                                               type="password"
                                               id="new_password">
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12">
                                        <label
                                            for="new_password_confirmation">{{ __('trx.passwords.confirm_password') }}
                                            *</label>
                                        <input class="form-control input-lg"
                                               name="new_password_confirmation"
                                               type="password"
                                               id="new_password_confirmation">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <base-button :role="'submit'">
                                            {{ __('trx.passwords.update_password') }}
                                        </base-button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-12 col-md-8 mt-5">
                <div class="header text-left">
                    <h2>{{ __('trx.my_profile') }}</h2>
                    <hr>
                </div>
            </div>
            <div class="col-md-12">
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="justify-content-center form-row">
                        <div class="col-xs-12 col-md-8">
                            <fieldset>
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="name">{{ __('trx.name') }}</label>
                                        @include('partials.has-errors', ['field' => 'name'])
                                        <input class="form-control input-lg"
                                               name="name"
                                               type="text"
                                               id="name"
                                               value="{{ old('name', $profile->name) }}">
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">&nbsp;</div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="city">{{ __('trx.city') }}</label>
                                        @include('partials.has-errors', ['field' => 'city'])
                                        <input class="form-control input-lg"
                                               name="city"
                                               type="text"
                                               id="city"
                                               value="{{ old('city', $profile->city) }}">
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="telephone">{{ __('trx.telephone') }}</label>
                                        @include('partials.has-errors', ['field' => 'telephone'])
                                        <input class="form-control input-lg"
                                               name="telephone"
                                               type="tel"
                                               id="telephone"
                                               value="{{ old('telephone', $profile->telephone) }}">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label for="info">{{ __('trx.personal_info') }}</label>
                                        @include('partials.has-errors', ['field' => 'info'])
                                        <textarea class="form-control input-lg"
                                                  name="info"
                                                  id="info"
                                                  rows="10"
                                                  cols="30">{{ old('info', $profile->info) }}</textarea>
                                        <small id="titleHelp" class="footnote form-text text-muted font-italic">
                                            {{ __('trx.personal_info_helper') }}
                                        </small>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label for="website" class="social">{{ __('trx.website') }}</label>
                                        @include('partials.has-errors', ['field' => 'website'])
                                        <input class="form-control input-lg"
                                               name="website"
                                               type="text"
                                               id="website"
                                               value="{{ old('website', $profile->website) }}">
                                        <small id="titleHelp" class="footnote form-text text-muted font-italic">
                                            {{ __('trx.website_helper') }}
                                        </small>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label for="facebook" class="social">Facebook</label>
                                        @include('partials.has-errors', ['field' => 'facebook'])
                                        <input class="form-control input-lg"
                                               name="facebook"
                                               type="text"
                                               id="facebook"
                                               value="{{ old('facebook') ?? $profile->facebook }}">
                                        <small id="titleHelp" class="footnote form-text text-muted font-italic">
                                            {{ __('trx.example_placeholder', ['value' => 'https://facebook.com/kolokasrecipes']) }}
                                        </small>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label for="twitter" class="social">Twitter</label>
                                        @include('partials.has-errors', ['field' => 'twitter'])
                                        <input class="form-control input-lg"
                                               name="twitter"
                                               type="text"
                                               id="twitter"
                                               value="{{ old('twitter', $profile->twitter) }}">
                                        <small id="titleHelp" class="footnote form-text text-muted font-italic">
                                            {{ __('trx.example_placeholder', ['value' => 'https://twitter.com/kolokasrecipes']) }}
                                        </small>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label for="pinterest" class="social">Pinterest</label>
                                        @include('partials.has-errors', ['field' => 'pinterest'])
                                        <input class="form-control input-lg"
                                               name="pinterest"
                                               type="text"
                                               id="pinterest"
                                               value="{{ old('pinterest', $profile->pinterest) }}">
                                        <small id="titleHelp" class="footnote form-text text-muted font-italic">
                                            {{ __('trx.example_placeholder', ['value' => 'https://pinterest.com/kolokasrecipes']) }}
                                        </small>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label for="instagram" class="social">Instagram</label>
                                        @include('partials.has-errors', ['field' => 'instagram'])
                                        <input class="form-control input-lg"
                                               name="instagram"
                                               type="text"
                                               id="instagram"
                                               value="{{ old('instagram', $profile->instagram) }}">
                                        <small id="titleHelp" class="footnote form-text text-muted font-italic">
                                            {{ __('trx.example_placeholder', ['value' => 'https://instagram.com/kolokasrecipes']) }}
                                        </small>
                                    </div>
                                    <!-- / column -->
                                    <div class="col-md-12 col-sm-12">
                                        <base-button :role="'submit'">
                                            {{ __('trx.update_profile') }}
                                        </base-button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div
        </div>
    </div>
@endsection
