<div class="row justify-content-center">
    @foreach($recipes as $recipe)
        <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
            <recipe-box :recipe="{{ $recipe->toJson() }}"></recipe-box>
        </div>
    @endforeach
</div>
