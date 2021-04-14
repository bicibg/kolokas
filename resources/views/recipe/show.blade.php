@extends('layouts.app')
@section('facebook_share_url')
    {{$recipe->url}}
@endsection
@section('facebook_share_title')
    {{ $recipe->title }}
@endsection
@section('facebook_share_description')
    {{ \Illuminate\Support\Str::limit($recipe->description, 197, $end='...') }}
@endsection
@section('facebook_share_image')
    @foreach($recipe->images as $image)
        @if($image->main)
            {{$image->url}}
            @break
        @endif
    @endforeach
@endsection
@section('sub_page_title')
    {{ $recipe->title }} -
@endsection
@section('content')
    <div class="container pt-0 pt-sm-5">
        <div class="row justify-content-center">
            <div class="col-md-8 single-post">
                <div id="single-content" class="inner-content">
                    <div class="heading">
                        <h2>{{ $recipe->title }}</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="recipe active">
                                        @include('recipe.partial.carousel')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="recipe-meta w-100 mb-5">
                            <div class="recipe-buttons no-print">
                                @livewire('favourite', ['recipe' => $recipe])
                                {{--<a href="javascript:void(0);"
                                   title="Add Comment">
                                    <i class="fa fa-comment"></i>
                                    <span class="d-inline-block">
                                        {{ 0 }} {{ \Illuminate\Support\Str::plural('comment', 0) }}
                                    </span>
                                </a>--}}
                                <a href="javascript:void(0);"
                                   rel="nofollow"
                                   onclick="window.print(); return false;"
                                   title="Printer Friendly, PDF &amp; Email">
                                    <i class="fa fa-print"></i>
                                    <span class="d-inline-block">
                                        {{ __('trx.print') }}
                                    </span>
                                </a>
                                <a data-toggle="modal"
                                   href="javascript:void(0);"
                                   data-target="#popup-social-{{ $recipe->slug }}"
                                   title="{{ __('trx.share') }}">
                                    <i class="fa fa-share"></i>
                                    <span class="d-inline-block">
                                        {{ __('trx.share') }}
                                    </span>
                                </a>
                            </div>
                            <ul>
                                @if ($recipe->prep_time)
                                    <li>{{ __('trx.prep_time') }}
                                        <strong>
                                            <i class="fa fa-clock-o"></i>
                                            {{ \Carbon\CarbonInterval::minutes($recipe->prep_time)->cascade() }}
                                        </strong>
                                    </li>
                                @endif
                                @if ($recipe->cook_time)
                                    <li>{{ __('trx.cook_time') }}
                                        <strong>
                                            <i class="fa fa-clock-o"></i>
                                            {{ \Carbon\CarbonInterval::minutes($revipe->cook_time)->cascade() }}
                                        </strong>
                                    </li>
                                @endif
                                @if ($recipe->servings)
                                    <li>{{ __('trx.servings') }}
                                        <strong>
                                            {{ __('trx.servings_for', ['for' => $recipe->servings]) }}
                                        </strong>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row recipe-details">
                            <div class="col-md-12">
                                <p>
                                    {!! nl2br(e($recipe->description))  !!}
                                </p>
                            </div>
                            <div class="col-md-5 col-sm-12">
                                <h3 class="section-title">{{ __('trx.ingredients') }}</h3>
                                <div class="ingredients-list">
                                    <ul class="ingredient-check">
                                        @foreach($recipe->getIngredientsArray() as $key => $ingredient)
                                            <li>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           class="custom-control-input no-print"
                                                           id="ingredient_{{ $key }}">
                                                    <label class="custom-control-label" for="ingredient_{{ $key }}">
                                                        {{ $ingredient }}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-12">
                                <div class="directions">
                                    <!-- Directions -->
                                    <h3 class="section-title">{{ __('trx.instructions') }}</h3>
                                    <div class="instructions">
                                        <ol>
                                            @foreach($recipe->getInstructionsArray() as $instruction)
                                                <li>
                                                    {{ $instruction }}
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p>
                                    {!! nl2br(e($recipe->notes))  !!}
                                </p>
                            </div>
                        </div>
                        @if ($recipe->author->locale !== app()->getLocale())
                            <div class="col-md-12 col-sm-12 col-12 text-left pl-0">
                                <a href="{{ route('contact.create', [$recipe]) }}" class="btn btn-link pl-0">
                                    {{ __('trx.translated_recipe') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @include('home.partial.contributor', ['contributors' => collect([$recipe->author->profile])])
    </div>
    @include('home.partial.recipes-showdown', ['recipes' => $youMayAlsoLike, 'title' => __('trx.you_may_also_like')])
    @include('partials.share-modal')
@endsection
