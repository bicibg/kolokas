@extends('layouts.app')

@section('content')
    <div class="container pt-0 pt-sm-5">
        <div class="row justify-content-center text-center">
            <div class="col-md-12">
                <h3 class="section-title">{{ __('nav.my_recipes') }}</h3>
            </div>
        </div>
        @if (!$published->count() && !$pending->count())
            <span>
                {{ __('recipe.user_has_no_recipes') }}
            </span>
            <a href="{{ route('recipe.create') }}">{{ __('recipe.create_one_now') }}</a>
        @else
            @if ($published->count())
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h5 class="text-center">
                            <i class="fa fa-cutlery" aria-hidden="true"></i>
                            {{ __(trans_choice('recipe.published_recipes', $published->count(), ['number' => $published->count()])) }}
                        </h5>
                    </div>
                    <div class="col-md-12">
                        <div class="row justify-content-center m-2">
                            @foreach($published as $recipe)
                                <div class="col-md-3 col-sm-6 col-12 d-flex align-items-stretch">
                                    @livewire('recipe-box', ['recipe'=>$recipe])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <div class="clearfix"></div>
            @if ($pending->count())
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h5 class="text-center">
                            <i class="fa fa-clock" aria-hidden="true"></i>
                            {{ __(trans_choice('recipe.pending_recipes', $pending->count(), ['number' => $pending->count()])) }}
                        </h5>
                    </div>
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            @foreach($pending as $recipe)
                                <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
                                    @livewire('recipe-box', ['recipe'=>$recipe])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection
