@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="form-group">
            <div class="input-group mb-3 has-clear">
                <input type="text" wire:model="searchTerm" placeholder="Search by Keyword"
                       value="" aria-describedby="clear">
                <div class="input-group-append form-control-clear form-control-feedback hidden">
                    <span class="input-group-text clear" id="clear">Clear</span>
                </div>
            </div>
        </div>
        {{ $searchTerm }}
        <div class="row justify-content-center">
            @if($recipes->count())
                <div class="col-lg-12">
                    <h5 class="text-center"><i class="fa fa-cutlery" aria-hidden="true"></i> {{ $recipes->count() }}
                        Recipes</h5>
                </div>
            @endif
            @forelse($recipes as $recipe)
                <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
                    @livewire('recipe-box', ['recipe'=>$recipe])
                </div>
            @empty
                No results found with this search, please try something else.
            @endforelse
        </div>
    </div>
@endsection
