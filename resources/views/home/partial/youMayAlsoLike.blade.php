<div class="row justify-content-center m-2">
    <div class="col-md-12">
        <div class="heading">
            <h2>{{ __('home.you_may_also_like') }}</h2>
        </div>
    </div>
    @foreach($youMayAlsoLike as $recipe)
        <div class="col-md-3 col-sm-6 col-12 d-flex align-items-stretch">
            @livewire('recipe-box', ['recipe'=>$recipe])
        </div>
    @endforeach
</div>


