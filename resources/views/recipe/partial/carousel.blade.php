<div id="recipeCarousel" class="carousel slide">
    @if ($recipe->images->count() > 1)
        <ol class="carousel-indicators">
            @foreach($recipe->images as $image)
                <li data-target="#recipeCarousel"
                    data-slide-to="{{ $loop->index }}"
                    class="{{ $image->main ? "active" : "" }}"></li>
            @endforeach
        </ol>
    @endif
    <div class="carousel-inner">
        @foreach($recipe->images as $image)
            <div class="carousel-item {{ $image->main ? "active" : "" }}">
                <img class="d-block w-100" src="{{ $image->url }}" alt="{{ $recipe->title }}">
            </div>
        @endforeach
    </div>
    @if ($recipe->images->count() > 1)
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
