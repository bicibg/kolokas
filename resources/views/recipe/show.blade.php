@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 single-post">
                <div id="single-content" class="inner-content">
                    <h1 class="h1 text-center mb-5 font-weight-bold text-dark">{{ $recipe->title }}</h1>
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

                                <li>Prep Time<strong>
                                        <i class="fa fa-clock-o"></i> {{ \Illuminate\Support\Str::plural($recipe->prep_time, 'minute') }}
                                    </strong></li>
                                <li>Cook Time<strong>
                                        <i class="fa fa-clock-o"></i> {{ \Illuminate\Support\Str::plural($recipe->cook_time, 'minute') }}
                                    </strong></li>
                                <li>Serving<strong>
                                        For {{ $recipe->servings }} </strong></li>
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
                                <h3 class="section-title">Ingredients</h3>
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
                                    <h3 class="section-title">Instructions</h3>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container pt-5 no-print">
        @include('home.partial.youMayAlsoLike')
    </div>
@endsection
