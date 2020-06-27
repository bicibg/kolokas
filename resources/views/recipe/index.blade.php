@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        @include('home.partial.search')
        <div class="row justify-content-center">
            @if($recipes->count())
                <div class="col-lg-12">
                    <h5 class="text-center">
                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                        {{ $count }} {{ \Illuminate\Support\Str::plural('Recipe', $count) }}
                    </h5>
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
        {{ $recipes->links() }}
    </div>
@endsection
