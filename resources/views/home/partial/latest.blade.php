<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="heading">
            <h2>Recently Added Recipes</h2>
        </div>
    </div>
    @foreach($latest as $recipe)
        <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
            <recipe-box :recipe="{{ $recipe->toJson() }}"></recipe-box>
        </div>
    @endforeach
</div>
