@extends('layouts.app')

@section('content')
    <div class="container">
        @livewire('search-box', ['resultCount' => $recipesCount, 'extended' => true, 'action' => route('recipe.favourites')])
        <div class="row justify-content-center text-center">
            <div class="col-md-12">
                <div class="heading">
                    <h2>{{ __('nav.my_favourites') }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
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
