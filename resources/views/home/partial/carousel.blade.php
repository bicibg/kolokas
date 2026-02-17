@if ($carousel->count())
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        @if ($carousel->count())
            <ol class="carousel-indicators list-unstyled">
                @php
                    $active = true
                @endphp
                @for($x=0; $x<$featured->count(); $x++)
                    <li data-bs-target="#myCarousel" data-bs-slide-to="{{ $x }}" class="{{ $active ? "active" : "" }}"></li>
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
                        <div class="carousel-caption text-end">
                            <h2><a href="{{ $recipe->url }}">{{ $recipe->title }}</a></h2>
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

            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">{{ __('trx.previous') }}</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">{{ __('trx.next') }}</span>
            </button>
        @endif
    </div>
@endif
