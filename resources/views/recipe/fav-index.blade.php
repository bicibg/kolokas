@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        @include('home.partial.search', ['action' => route('recipe.favourites')])
        <div class="row justify-content-center text-center">
            <div class="col-md-12">
                <h3 class="section-title">{{ __('nav.my_favourites') }}</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            @if($recipes->count())
                <div class="col-lg-12">
                    <h5 class="text-center">
                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                        {{ __(trans_choice('recipe.recipe', $recipes->count())) }}
                    </h5>
                </div>
            @endif
            @forelse($recipes as $recipe)
                <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
                    @livewire('recipe-box', ['recipe'=>$recipe])
                </div>
            @empty
                <span>{{ __('recipe.no_favourites') }}</span>
            @endforelse
        </div>
        {{ $recipes->links() }}
    </div>
@endsection
