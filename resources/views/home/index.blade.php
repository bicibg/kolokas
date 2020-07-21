@extends('layouts.app')

@section('content')
    @include('home.partial.carousel')
    <div class="container">
        @livewire('search-box')
    </div>
    <div class="container pt-0 pt-sm-5">
        @include('home.partial.mostFavourited')
    </div>
    <div class="container pt-0 pt-sm-5">
        @include('home.partial.mostVisited')
    </div>
    <div class="container pt-0 pt-sm-5">
        @include('home.partial.featured')
    </div>
    <div class="container pt-0 pt-sm-5">
        @include('home.partial.latest')
    </div>
    <div class="container pt-0 pt-sm-5">
        @include('home.partial.contributor')
    </div>
@endsection
