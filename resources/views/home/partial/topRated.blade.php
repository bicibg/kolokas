<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="heading">
            <h2>Most Favourited Recipes</h2>
        </div>
    </div>
    @foreach($topRated as $recipe)
        <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
            @livewire('recipe-box', ['recipe'=>$recipe])
        </div>
    @endforeach
</div>


