@extends('layouts.app')

@section('content')
    @include('home.partial.carousel')
    <div class="container pt-5" style="max-width:1400px !important;">
        @include('home.partial.featured')
    </div>
    <div class="container pt-5" style="max-width:1400px !important;">
        @include('home.partial.latest')
    </div>
    <div class="container pt-5" style="max-width:1400px !important;">
        @include('home.partial.topRated')
    </div>
    <div class="container pt-5" style="max-width:1400px !important;">
        @include('home.partial.contributor')
    </div>
@endsection
