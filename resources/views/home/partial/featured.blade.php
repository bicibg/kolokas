<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="heading">
            <h2>Editor's Choice</h2>
        </div>
    </div>
    @foreach($featured as $recipe)
        <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch">
            <recipe :recipe="{{ $recipe->toJson() }}"></recipe>
        </div>
    @endforeach
</div>


