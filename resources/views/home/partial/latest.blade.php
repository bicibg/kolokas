<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="heading">
            <h2>{{ __('home.recently_added') }}</h2>
        </div>
    </div>
    @foreach($latest as $recipe)
        <div class="col-md-3 col-sm-4 d-flex align-items-stretch">
            @livewire('recipe-box', ['recipe'=>$recipe])
        </div>
    @endforeach
</div>
