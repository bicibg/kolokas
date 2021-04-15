<div id="recipeCarousel" class="carousel slide">
    @if ($recipe->images->count() > 0)
        <ol class="carousel-indicators">
            <li data-target="#recipeCarousel"
                data-slide-to="0"></li>
            @foreach($recipe->images as $image)
                <li data-target="#recipeCarousel"
                    data-slide-to="{{ $loop->index + 1 }}"></li>
            @endforeach
        </ol>
    @endif
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="{{ $recipe->main_image }}" alt="{{ $recipe->title }}">
        </div>
        @foreach($recipe->images as $image)
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ $image->url }}" alt="{{ $recipe->title }}">
            </div>
        @endforeach
    </div>
    @if ($recipe->images->count() > 0)
        <a class="carousel-control-prev" href="#recipeCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">{{ __('trx.previous') }}</span>
        </a>
        <a class="carousel-control-next" href="#recipeCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">{{ __('trx.next') }}</span>
        </a>
    @endif
</div>
