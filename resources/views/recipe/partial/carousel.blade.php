<div id="recipeCarousel" class="carousel slide">
    @if ($recipe->images->count() > 0)
        <ol class="carousel-indicators">
            <li data-bs-target="#recipeCarousel"
                data-bs-slide-to="0"></li>
            @foreach($recipe->images as $image)
                <li data-bs-target="#recipeCarousel"
                    data-bs-slide-to="{{ $loop->index + 1 }}"></li>
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
        <button class="carousel-control-prev" type="button" data-bs-target="#recipeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">{{ __('trx.previous') }}</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#recipeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">{{ __('trx.next') }}</span>
        </button>
    @endif
</div>
