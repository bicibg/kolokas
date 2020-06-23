@extends('layouts.app')

@section('content')
    @include('home.partial.carousel')
    @include('home.partial.search')
    <div class="container pt-5">
        @include('home.partial.topRated')
    </div>
    <div class="container pt-5">
        @include('home.partial.featured')
    </div>
    <div class="container pt-5">
        @include('home.partial.latest')
    </div>
    <div class="container pt-5">
        @include('home.partial.contributor')
    </div>
@endsection
