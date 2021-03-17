@if ($recipes->count())
    <div class="container pt-0 pt-sm-5">
        <div class="row justify-content-center m-2">
            <div class="col-md-12">
                <div class="heading">
                    <h2>{{ $title }}</h2>
                </div>
            </div>
            @foreach($recipes as $recipe)
                <div class="col-md-3 col-sm-6 col-12 d-flex align-items-stretch">
                    @livewire('recipe-box', ['recipe'=>$recipe])
                </div>
            @endforeach
        </div>
    </div>
@endif
