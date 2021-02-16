@extends('layouts.app')

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
                                        {{ __('general.print') }}
                                    </span>
                                </a>
                                <a data-toggle="modal"
                                   href="javascript:void(0);"
                                   data-target="#popup-social-{{ $recipe->slug }}"
                                   title="{{ __('recipe.share') }}">
                                    <i class="fa fa-share"></i>
                                    <span class="d-inline-block">
                                        {{ __('recipe.share') }}
                                    </span>
                                </a>
                            </div>
                            <ul>
                                @if ($recipe->getAttributes()['prep_time'])
                                    <li>{{ __('recipe.prep_time') }}
                                        <strong>
                                            <i class="fa fa-clock-o"></i>
                                            {{ $recipe->prep_time }}
                                        </strong>
                                    </li>
                                @endif
                                @if ($recipe->getAttributes()['cook_time'])
                                    <li>{{ __('recipe.cook_time') }}
                                        <strong>
                                            <i class="fa fa-clock-o"></i>
                                            {{ $recipe->cook_time }}
                                        </strong>
                                    </li>
                                @endif
                                @if ($recipe->getAttributes()['servings'])
                                    <li>{{ __('recipe.servings') }}
                                        <strong>
                                            {{ __('recipe.servings_for', ['for' => $recipe->servings]) }}
                                        </strong>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row recipe-details">
                            <div class="col-md-12">
                                <p>
                                    {{ $recipe->description }}
                                </p>
                            </div>
                            <div class="col-md-5 col-sm-12">
                                <h3 class="section-title">{{ __('recipe.ingredients') }}</h3>
                                <div class="ingredients-list">
                                    <ul class="ingredient-check">
                                        @foreach($recipe->ingredients as $key => $ingredient)
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
                                    <h3 class="section-title">{{ __('recipe.instructions') }}</h3>
                                    <div class="instructions">
                                        <ol>
                                            @foreach($recipe->instructions as $instruction)
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
                                    {{ $recipe->notes }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-12 d-flex align-items-stretch"></div>
                        <div class="col-md-4 col-sm-12 col-12 d-flex align-items-stretch">
                            @livewire('author-box', ['profile' => $recipe->author->profile])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container pt-0 pt-sm-5 no-print">
        @include('home.partial.youMayAlsoLike')
    </div>
@endsection
