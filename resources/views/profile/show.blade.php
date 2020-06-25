@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 justify-content-center">
                <div class="row">
                    @if($recipes->count())
                        <div class="col-lg-12">
                            <h5 class="text-center"><i class="fa fa-cutlery" aria-hidden="true"></i> Recipes</h5>
                        </div>
                    @endif
                    @forelse($recipes as $recipe)
                        <div class="col-md-4 col-sm-4 col-xs-6 d-flex align-items-stretch p-2">

                            @livewire('recipe-box', ['recipe'=>$recipe])

                        </div>
                    @empty
                        <div class="col-md-12">
                            This is user has currently no recipes.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-md-4 justify-content-center border-left p-2">
                <div class="row">
                    <div class="col-lg-11">
                        <h5 class="text-center"><i class="fa fa-user" aria-hidden="true"></i> Author</h5>
                        <contributor-box :profile="{{ $profile->toJson() }}"></contributor-box>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
