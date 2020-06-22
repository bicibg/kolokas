@extends('layouts.app')

@section('content')
    @include('recipe.partial.featured')

    <div class="container pt-5" style="max-width:1400px !important;">
        @include('recipe.partial.recipes')
    </div>
@endsection
