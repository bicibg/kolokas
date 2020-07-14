<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="heading">
            <h2>{{ __('home.editors_choice') }}</h2>
        </div>
    </div>
    @foreach($featured as $recipe)
        <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
            @livewire('recipe-box', ['recipe'=>$recipe])
        </div>
    @endforeach
</div>


