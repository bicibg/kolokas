@if ($recipes->count())
    <div class="container pt-0 pt-sm-5 no-print">
        <div class="row justify-content-center m-2">
            @if (!empty($title))
                <div class="col-md-12">
                    <div class="heading">
                        <h2>{{ $title }}</h2>
                    </div>
                </div>
            @endif
            @foreach($recipes as $recipe)
                <div class="col-md-3 col-sm-6 col-12 d-flex align-items-stretch">
                    @livewire('recipe-box', ['recipe'=>$recipe])
                </div>
            @endforeach
        </div>
    </div>
@endif
