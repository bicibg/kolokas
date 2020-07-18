@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center text-center">
            <div class="col-md-12">
                <h3 class="section-title">{{ __('nav.recipes') }}</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            @if($recipesCount)
                <div class="col-md-12">
                    <h5 class="text-center">
                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                        {{ trans_choice('recipe.recipes_found', $recipesCount, ['number' => $recipesCount]) }}
                    </h5>
                </div>
            @endif
            <div class="col-md-12">
                @include('home.partial.search')
            </div>
            @forelse($recipes as $recipe)
                <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
                    @livewire('recipe-box', ['recipe'=>$recipe])
                </div>
            @empty
                {{ __('recipe.no_recipes_found') }}
            @endforelse
        </div>
        {{ $recipes->links() }}
    </div>
@endsection
