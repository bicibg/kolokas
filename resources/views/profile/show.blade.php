@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-xs-12 col-sm-8">
                <h2>{{ $profile->name }}</h2>
                @if ($profile->info)
                    <p><strong>{{ __('profile.about') }}: </strong> {{ $profile->info }} </p>
                @endif
                @if ($profile->city)
                    <p>
                        <strong>{{ __('profile.city') }}: </strong> {{ $profile->city }}
                    </p>
                @endif
            </div>
            <div class="col-12 col-sm-4 text-center border-left border-darker">
                @if ($profile->website || $profile->facebook || $profile->instagram || $profile->twitter || $profile->pinterest)
                    <h6><strong>{{ __('profile.social_media') }}</strong></h6>
                @endif
                @if($profile->website)
                    <p>
                        <i class="fa fa-globe"></i>
                        <a href="{{ $profile->website }}" class="btn-link">{{ $profile->website }}</a>
                    </p>
                @endif
                @if($profile->facebook)
                    <p>
                        <i class="fa fa-facebook"></i>
                        <a href="{{ $profile->website }}" class="btn-link">{{ $profile->website }}</a>
                    </p>
                @endif
                @if($profile->instagram)
                    <p>
                        <i class="fa fa-instagram"></i>
                        <a href="{{ $profile->website }}" class="btn-link">{{ $profile->website }}</a>
                    </p>
                @endif
                @if($profile->twitter)
                    <p>
                        <i class="fa fa-twitter"></i>
                        <a href="{{ $profile->website }}" class="btn-link">{{ $profile->website }}</a>
                    </p>
                @endif
                @if($profile->pinterest)
                    <p>
                        <i class="fa fa-pinterest"></i>
                        <a href="{{ $profile->website }}" class="btn-link">{{ $profile->website }}</a>
                    </p>
                @endif
            </div>
        </div>
        <div class="row mt-3">
            @if ($recipes->count())
                <div class="row justify-content-center">

                    <div class="col-md-12">
                        <h5 class="text-center">
                            <i class="fa fa-cutlery" aria-hidden="true"></i>
                            {{ __(trans_choice('recipe.recipes_found', $recipes->count(), ['number' => $recipes->count()])) }}
                        </h5>
                    </div>
                    <div class="col-md-12">
                        <div class="row justify-content-center m-2">
                            @forelse($recipes as $recipe)
                                <div class="col-md-3 col-sm-6 col-12 d-flex align-items-stretch">
                                    @livewire('recipe-box', ['recipe'=>$recipe])
                                </div>
                            @empty
                                <div class="col-md-12">
                                    This is user has currently no recipes.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            @endif



        </div>

        {{--            <div class="col-md-8 justify-content-center">--}}
        {{--                <div class="row">--}}
        {{--                    @if($recipes->count())--}}
        {{--                        <div class="col-lg-12">--}}
        {{--                            <h5 class="text-center"><i class="fa fa-cutlery" aria-hidden="true"></i> Recipes</h5>--}}
        {{--                        </div>--}}
        {{--                    @endif--}}
        {{--                    @forelse($recipes as $recipe)--}}
        {{--                        <div class="col-md-4 col-sm-4 col-xs-6 d-flex align-items-stretch p-2">--}}

        {{--                            @livewire('recipe-box', ['recipe'=>$recipe])--}}

        {{--                        </div>--}}
        {{--                    @empty--}}
        {{--                        <div class="col-md-12">--}}
        {{--                            This is user has currently no recipes.--}}
        {{--                        </div>--}}
        {{--                    @endforelse--}}
        {{--                </div>--}}
        {{--            </div>--}}

        {{--            <div class="col-md-4 justify-content-center border-left p-2">--}}
        {{--                <div class="row">--}}
        {{--                    <div class="col-lg-11">--}}
        {{--                        <h5 class="text-center"><i class="fa fa-user" aria-hidden="true"></i> Author</h5>--}}
        {{--                        @livewire('author-box', ['profile' => $profile])--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
    </div>
    </div>
@endsection
