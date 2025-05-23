@if ($carousel->count())
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        @if ($carousel->count())
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
        @endif
        <div class="carousel-inner">
            @php
                $active = true
            @endphp
            @foreach($carousel as $recipe)
                <div class="carousel-item {{ $active ? "active" : "" }}">
                    <img class="d-block w-100" src="{{ $recipe->main_image }}" alt="{{ $recipe->title }}">
                    <div class="container">
                        <div class="carousel-caption text-right">
                            <h1><a href="{{ $recipe->url }}">{{ $recipe->title }}</a></h1>
                            <p>
                                {{ \Illuminate\Support\Str::limit($recipe->description, 250, $end='...') }}
                            </p>
                            <a href="{{ $recipe->url }}" class="btn-link">{{ __('trx.read_more') }}</a>
                        </div>
                    </div>
                </div>
                @php
                    $active = false
                @endphp
            @endforeach
        </div>
        @if ($carousel->count() > 1)

            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">{{ __('trx.previous') }}</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">{{ __('trx.next') }}</span>
            </a>
        @endif
    </div>
@endif
