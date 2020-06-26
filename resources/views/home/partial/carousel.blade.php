<div id="myCarousel" class="carousel slide">
    <ol class="carousel-indicators">
        @php
            $active = true
        @endphp
        @for($x=0; $x<$featured->count(); $x++)
            <li data-target="#myCarousel" data-slide-to="{{ $x }}" class="{{ $active ? "active" : "" }}"></li>
            @php
                $active = false
            @endphp
        @endfor
    </ol>
    <div class="carousel-inner">
        @php
            $active = true
        @endphp
        @foreach($carousel as $recipe)
            <div class="carousel-item {{ $active ? "active" : "" }}">
                <img class="d-block w-100" src="{{ $recipe->image->url }}" alt="{{ $recipe->title }}">
                <div class="container">
                    <div class="carousel-caption text-right">
                        <h1><a href="{{ $recipe->url }}">{{ $recipe->title }}</a></h1>
                        <p>{{ $recipe->description }}</p>
                        <p>
                            <base-button :hrefProp="'{{ route('recipe.show', $recipe) }}'">
                                Read more
                            </base-button>
                        </p>
                    </div>
                </div>
            </div>
            @php
                $active = false
            @endphp
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
