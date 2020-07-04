@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        @if (!$published->count() && !$pending->count())
            You don't have any recipes yet.
            <a href="{{ route('recipe.create') }}">Create one now.</a>
        @else
            @if ($published->count())
                <div class="row justify-content-center">

                    <div class="col-md-12">
                        <h5 class="text-center">
                            <i class="fa fa-cutlery" aria-hidden="true"></i>
                            {{ $published->count() }}
                            Published {{ \Illuminate\Support\Str::plural('recipe', $published->count()) }}
                        </h5>
                    </div>
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            @foreach($published as $recipe)
                                <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
                                    @livewire('recipe-box', ['recipe'=>$recipe])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <div class="clearfix"></div>
            @if ($pending->count())
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h5 class="text-center">
                            <i class="fa fa-clock" aria-hidden="true"></i>
                            {{ $pending->count() }}
                            Pending {{ \Illuminate\Support\Str::plural('recipe', $pending->count()) }}
                        </h5>
                    </div>
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            @foreach($pending as $recipe)
                                <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
                                    @livewire('recipe-box', ['recipe'=>$recipe])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection
