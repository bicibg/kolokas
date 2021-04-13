@extends('layouts.app')

@section('content')
    @include('home.partial.carousel')
    @if (\App\Models\Recipe::count())
        <div class="container">
            @livewire('recipe-search-box')
        </div>
    @endif
    @include('home.partial.recipes-showdown', ['recipes' => $mostFavourited, 'title' => __('trx.most_favourited')])
    @include('home.partial.recipes-showdown', ['recipes' => $mostVisited, 'title' => __('trx.most_viewed')])
    @include('home.partial.recipes-showdown', ['recipes' => $featured, 'title' => __('trx.editors_choice')])
    @include('home.partial.recipes-showdown', ['recipes' => $latest, 'title' => __('trx.recently_added')])
    @include('home.partial.contributor', ['contributors' => $contributors, 'title' => __('trx.top_authors') ])
@endsection
