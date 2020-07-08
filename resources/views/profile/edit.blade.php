@extends('layouts.app')

@section('content')
    <div class="container kolokas-form">
        @if(session()->has('message'))
            <div class="alert alert-success">{{session()->get('message')}}</div>
        @endif
        @if(count($errors)>0)
            <ul>
                @foreach($errors->all() as $error)
                    <li class="alert alert-danger">{{$error}}</li>
                @endforeach
            </ul>
        @endif
        <div class="row justify-content-center kolokas-form">
            <div class="col-sm-12 col-md-8">
                <div class="header text-left">
                    <h2>Account</h2>
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
                                        <label for="email">E-mail</label>
                                        <input class="form-control-plaintext"
                                               readonly
                                               id="email"
                                               value="{{ auth()->user()->email }}">
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12">
                                        <label for="current_password">Current Password * </label>
                                        <input class="form-control input-lg" name="current_password" type="password"
                                               id="current_password">
                                        <small id="titleHelp" class="footnote form-text text-muted font-italic">Your
                                            current password</small>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12">
                                        <label for="new_password">New Password *</label>
                                        <input class="form-control input-lg" name="new_password" type="password"
                                               id="new_password">
                                        <small id="titleHelp" class="footnote form-text text-muted font-italic">Your new
                                            password</small>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12">
                                        <label for="new_password_confirmation">Repeat Password *</label>
                                        <input class="form-control input-lg"
                                               name="new_password_confirmation"
                                               type="password"
                                               id="new_password_confirmation">
                                        <small id="titleHelp" class="footnote form-text text-muted font-italic">Repeat
                                            your new password</small>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <base-button :role="'submit'">
                                            {{ __('Update password') }}
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
                    <h2>Profile</h2>
                    <hr>
                </div>
            </div>
            <div class="col-md-12">
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="justify-content-center form-row">
                        <div class="col-xs-12 col-md-8">
                            <fieldset>
                                <div class="row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="first-name">Name</label>
                                        <input class="form-control input-lg" name="first-name" type="text"
                                               id="name" value="{{ old('name') ?? $profile->name }}">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label for="description">Information</label>
                                        <textarea class="form-control input-lg" name="description" id="description"
                                                  rows="10" cols="30"></textarea>
                                        <small id="titleHelp" class="footnote form-text text-muted font-italic">Keep
                                            it short and descriptive</small>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label for="facebook">Facebook</label>
                                        <input class="form-control input-lg" name="facebook" type="text"
                                               id="facebook" value="">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label for="twitter">Twitter</label>
                                        <input class="form-control input-lg" name="twitter" type="text" id="twitter"
                                               value="">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label for="pinterest">Pinterest</label>
                                        <input class="form-control input-lg" name="pinterest" type="text"
                                               id="pinterest" value="">
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <label for="instagramm">Instagram</label>
                                        <input class="form-control input-lg" name="instagramm" type="text"
                                               id="instagramm" value="">
                                    </div>
                                    <!-- / column -->
                                    <div class="col-md-12 col-sm-12">
                                        <base-button :role="'submit'">
                                            {{ __('Update profile') }}
                                        </base-button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
            {{--
                        <div class="col-md-12">
                            <div class="col-sm-12 col-md-8">
                                <div class="header text-left">
                                    <h2>Profile</h2>
                                    <hr>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form method="post" action="{{ route('profile.update') }}">
                                    @csrf
                                    <div class="justify-content-center form-row">
                                        <div class="col-xs-12 col-md-8">
                                            <fieldset>
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-sm-12">
                                                        <label for="first-name">Name</label>
                                                        <input class="form-control input-lg" name="first-name" type="text"
                                                               id="name" value="">
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12">
                                                        <label for="description">Information</label>
                                                        <textarea class="form-control input-lg" name="description" id="description"
                                                                  rows="10" cols="30"></textarea>
                                                        <small id="titleHelp" class="footnote form-text text-muted font-italic">Keep
                                                            it short and descriptive</small>
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12">
                                                        <label for="facebook">Facebook</label>
                                                        <input class="form-control input-lg" name="facebook" type="text"
                                                               id="facebook" value="">
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12">
                                                        <label for="twitter">Twitter</label>
                                                        <input class="form-control input-lg" name="twitter" type="text" id="twitter"
                                                               value="">
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12">
                                                        <label for="pinterest">Pinterest</label>
                                                        <input class="form-control input-lg" name="pinterest" type="text"
                                                               id="pinterest" value="">
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12">
                                                        <label for="instagramm">Instagram</label>
                                                        <input class="form-control input-lg" name="instagramm" type="text"
                                                               id="instagramm" value="">
                                                    </div>
                                                    <!-- / column -->
                                                    <div class="col-md-12 col-sm-12">
                                                        <base-button :role="'submit'">
                                                            {{ __('Update profile') }}
                                                        </base-button>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
            --}}
        </div>
    </div>
@endsection
