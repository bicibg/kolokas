<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="heading">
            <h2>{{ __('home.most_viewed') }}</h2>
        </div>
    </div>
    @foreach($mostVisited as $recipe)
        <div class="col-md-3 col-sm-4 d-flex align-items-stretch">
            @livewire('recipe-box', ['recipe'=>$recipe])
        </div>
    @endforeach
</div>


