@extends('layouts.app')

@section('content')
    <div class="container kolokas-form">
        <div class="row justify-content-center kolokas-form">
            <div class="col-xs-12 col-md-8">
                <div class="header text-left">
                    <h2>Edit My Profile</h2>
                    <p>You can edit information that appears on your Kolokas.com profile, such as your email address or
                        contact information. Changing your profile options lets you control how others see you and your
                        profile.</p>
                    <hr>
                </div>
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
            </div>
            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                <div class="justify-content-center form-row">
                    <div class="col-xs-12 col-md-8">
                        <fieldset>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="first-name">Name</label>
                                    <input class="form-control input-lg" name="first-name" type="text"
                                           id="name" value="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="email">E-mail *</label>
                                    <input class="form-control input-lg" name="email" type="text" id="email" value="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="pass1">Password * </label>
                                    <input class="form-control input-lg" name="pass1" type="password"
                                           id="pass1">
                                    <small id="titleHelp" class="footnote form-text text-muted font-italic">Create
                                        a password</small>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="pass2">Repeat Password *</label>
                                    <input class="form-control input-lg" name="pass2" type="password"
                                           id="pass2">
                                    <small id="titleHelp" class="footnote form-text text-muted font-italic">Confirm
                                        your password</small>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="description">Information</label>
                                    <textarea class="form-control input-lg" name="description" id="description"
                                              rows="10" cols="30"></textarea>
                                    <small id="titleHelp" class="footnote form-text text-muted font-italic">Keep
                                        it short and descriptive</small>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="facebook">Facebook</label>
                                    <input class="form-control input-lg" name="facebook" type="text"
                                           id="facebook" value="">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="twitter">Twitter</label>
                                    <input class="form-control input-lg" name="twitter" type="text" id="twitter"
                                           value="">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="pinterest">Pinterest</label>
                                    <input class="form-control input-lg" name="pinterest" type="text"
                                           id="pinterest" value="">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="instagramm">Instagram</label>
                                    <input class="form-control input-lg" name="instagramm" type="text"
                                           id="instagramm" value="">
                                </div>
                                <!-- / column -->
                                <div class="col-sm-12">
                                    <base-button :role="'submit'">
                                        {{ __('Update profile') }}
                                    </base-button>
                                    <input type="hidden" id="_wpnonce" name="_wpnonce" value="183f6a75c9"><input
                                        type="hidden" name="_wp_http_referer"
                                        value="/quickrecipe/edit-my-profile/"> <input name="action"
                                                                                      type="hidden" id="action"
                                                                                      value="update-user">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
