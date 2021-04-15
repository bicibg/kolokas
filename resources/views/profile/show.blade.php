@extends('layouts.app')
@section('facebook_share_url')
    {{$profile->url}}
@endsection
@section('facebook_share_title')
    {{$profile->name}}
@endsection
@section('facebook_share_description')
    {{ \Illuminate\Support\Str::limit($profile->info, 197, $end='...') }}
@endsection
@section('sub_page_title')
    {{ $profile->name }} -
@endsection
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-xs-12 col-sm-8">
                <h2>{{ $profile->name }}</h2>
                @if ($profile->info)
                    <p><strong>{{ __('trx.about') }}: </strong> {{ $profile->info }} </p>
                @endif
                @if ($profile->city)
                    <p>
                        <strong>{{ __('trx.city') }}: </strong> {{ $profile->city }}
                    </p>
                @endif
            </div>
            <div class="col-12 col-sm-4 text-center border-left border-darker">
                @if ($profile->website || $profile->facebook || $profile->instagram || $profile->twitter || $profile->pinterest)
                    <h6><strong>{{ __('trx.social_media') }}</strong></h6>
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
                        <a href="{{ $profile->facebook }}" class="btn-link">{{ $profile->facebook }}</a>
                    </p>
                @endif
                @if($profile->instagram)
                    <p>
                        <i class="fa fa-instagram"></i>
                        <a href="{{ $profile->instagram }}" class="btn-link">{{ $profile->instagram }}</a>
                    </p>
                @endif
                @if($profile->twitter)
                    <p>
                        <i class="fa fa-twitter"></i>
                        <a href="{{ $profile->twitter }}" class="btn-link">{{ $profile->twitter }}</a>
                    </p>
                @endif
                @if($profile->pinterest)
                    <p>
                        <i class="fa fa-pinterest"></i>
                        <a href="{{ $profile->pinterest }}" class="btn-link">{{ $profile->pinterest }}</a>
                    </p>
                @endif
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                @if ($recipes->count())
                    <h5 class="text-center">
                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                        {{ __(trans_choice('trx.recipes_found', $recipes->count(), ['number' => $recipes->count()])) }}
                    </h5>
                @else
                    {{ __('trx.user_no_recipes') }}
                @endif

            </div>
        </div>

        @include('home.partial.recipes-showdown', ['recipes' => $recipes, 'title' => ''])

    </div>
@endsection
