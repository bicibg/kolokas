@extends('layouts.app')

@section('content')
    <div class="container pt-0 pt-sm-5">
        <div class="row justify-content-center text-center">
            <div class="col-md-12">
                <h3 class="section-title">{{ __('trx.my_favourites') }}</h3>
            </div>
        </div>
        @if(auth()->user() && auth()->user()->favourites()->count())
            @livewire('recipe-search-box', ['resultCount' => $recipesCount, 'extended' => true, 'action' =>
            route('recipe.favourites')])
        @endif

        <div class="row justify-content-center m-2">
            @forelse($recipes as $recipe)
                <div class="col-md-3 col-sm-6 col-12 d-flex align-items-stretch">
                    @livewire('recipe-box', ['recipe'=>$recipe])
                </div>
            @empty
                <span>{{ __('trx.no_favourites') }}</span>
            @endforelse
        </div>
        <div class="d-flex justify-content-center">
            {{ $recipes->withQueryString()->links() }}
        </div>
    </div>
@endsection
