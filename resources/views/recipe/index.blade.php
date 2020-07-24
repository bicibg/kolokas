@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        @livewire('recipe-search-box', ['resultCount' => $recipesCount, 'extended' => true])
        <div class="row justify-content-center text-center">
            <div class="col-md-12">
                <div class="heading">
                    <h2>{{ __('nav.recipes') }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center m-2">
            @forelse($recipes as $recipe)
                <div class="col-md-3 col-sm-6 col-12 d-flex align-items-stretch">
                    @livewire('recipe-box', ['recipe'=>$recipe])
                </div>
            @empty
                <span>{{ __('recipe.no_recipes_found') }}</span>
            @endforelse
        </div>
        <div class="d-flex justify-content-center">
            {{ $recipes->withQueryString()->links() }}
        </div>
    </div>
@endsection
