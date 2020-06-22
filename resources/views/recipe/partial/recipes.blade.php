<div class="row justify-content-center">
    <div class="col-lg-12">
        <h5><i class="fa fa-cutlery" aria-hidden="true"></i> Recipes</h5>
    </div>
    @foreach($recipes as $recipe)
        <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
            <recipe-box :recipe="{{ $recipe->toJson() }}"></recipe-box>
        </div>
    @endforeach
    {{ $recipes->links() }}
</div>
