@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center w-100 m-0 pb-3">
            @livewire('recipe-search')
        </div>
        @livewire('recipes')
    </div>
@endsection
