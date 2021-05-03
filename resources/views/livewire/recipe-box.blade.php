<div class="recipe-container d-flex flex-column w-100">
    @if($recipe->traditional)
        <span class="badge badge-pill badge-primary position-absolute traditional-badge text-light">{{ __('trx.traditional') }}</span>
    @endif
    <div class="recipe-img">
        <img alt="{{ $recipe->title }}" src="{{ $recipe->main_image }}"
             height="266" width="400">

        @if ($recipe->author->is(auth()->user()))
            <a href="{{ route('recipe.edit', $recipe) }}">
                <div class="hover-button hover-button-first">{{ __('trx.edit') }}</div>
            </a>
            <div class="clearfix"></div>
            <a href="{{ $recipe->url }}">
                <div class="hover-button hover-button-second">{{ __('trx.view') }}</div>
            </a>
        @else
            <a href="{{ $recipe->url }}">
                <div class="hover-button hover-button-single">{{ __('trx.view') }}</div>
            </a>
        @endif
    </div>
    <div class="recipe-meta text-center">
        <span><i class="fa fa-heart"></i> {{ $recipe->favourites->count() }} {{ trans_choice('trx.likes', $recipe->favourites->count() ) }}</span>
        <span><i class="fa fa-eye"></i> {{ $recipe->visitsCount }}  {{ trans_choice('trx.views', $recipe->visitsCount ) }}</span>
    </div>
    <div class="recipe-content">
        <h3>
            <a href="{{ $recipe->url }}">
                {{ $recipe->title }}
            </a>
            <small class="text-break">
                {{ \Illuminate\Support\Str::limit($recipe->description, 150, $end='...') }}
            </small></h3>
    </div>
    <div class="avatar recipe-footer flex-grow-1 d-flex flex-column">
        <div class="flex-grow-1"></div>
        <div class="clearfix">
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left">
{{--                        <img alt=""--}}
{{--                             class="avatar avatar-25 photo"--}}
{{--                             height="25"--}}
{{--                             src="{{Avatar::create($recipe->author->name)->toBase64()}}"--}}
{{--                             width="25">--}}
                        <a href="{{ $recipe->author->profile->url }}" rel="author">{{ $recipe->author->name }}</a>
                        <p class="font-italic small">{{ $recipe->author->profile->city }}</p>
                    </div>
                </div>
                {{--                <div class="col-md-4">--}}
                {{--                    <span class="user-ratings pull-right">--}}
                {{--                        <i class="fa fa-star fa-xs"></i>--}}
                {{--                        <i class="fa fa-star fa-xs"></i>--}}
                {{--                        <i class="far fa-star fa-xs"></i>--}}
                {{--                        <i class="far fa-star fa-xs"></i>--}}
                {{--                        <i class="far fa-star fa-xs"></i>--}}
                {{--                    </span>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
    <div class="recipe-buttons">
        <a href="javascript:void(0);"
           title="{{ __('trx.add_to_favourites') }}"
           wire:key="favourite_{{time()}}"
           wire:id
           wire:click="favourite"><i class="fa @if($recipe->isFavourited()) fa-heart red @else fa-heart-o @endif"></i></a>
        <a data-toggle="modal" href="javascript:void(0);" data-target="#popup-social-{{ $recipe->slug }}" title="{{ __('trx.share') }}">
            <i class="fa fa-share"></i>
        </a>
    </div>
    @include('partials.share-modal')
</div>
