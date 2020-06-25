<div class="recipe-container d-flex flex-column">
    <div class="recipe-img">
        <img alt="{{ $recipe->title }}" src="{{ $recipe->images[0]->url }}"
             height="266" width="400">
        <a href="{{ $recipe->url }}">
            <div class="hover-button">View Recipe</div>
        </a>
    </div>
    <div class="recipe-meta text-center">
        @php
            $comments = rand(0, 100);
            $views = rand(50, 200);
        @endphp
        <span><i class="fa fa-comments"></i> {{ $comments }} {{ \Illuminate\Support\Str::plural('comment', $comments) }}</span>
        <span><i class="fa fa-eye"></i> {{ $views }} {{ \Illuminate\Support\Str::plural('view', $views) }}</span>
    </div>
    <div class="recipe-content">
        <h3>
            <a href="{{ $recipe->url }}">
                {{ $recipe->title }}
            </a>
            <small class="text-break">
                {{ $recipe->description }}
            </small></h3>
    </div>
    <div class="avatar recipe-footer flex-grow-1 d-flex flex-column">
        <div class="flex-grow-1"></div>
        <div class="clearfix">
            <div class="row">
                <div class="col-md-8">
                    <div class="pull-left">
                        <img alt=""
                             class="avatar avatar-25 photo"
                             height="25"
                             src="http://1.gravatar.com/avatar/af8f966d8961c37e29603e8e4fbdd337?s=25&amp;d=mm&amp;r=g"
                             width="25">
                        By
                        <a href="{{ $recipe->author->profile->url }}" rel="author"
                           title="Posts by admin"> {{ $recipe->author->name }}</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <span class="user-ratings pull-right">
                        <i class="fa fa-star fa-xs"></i>
                        <i class="fa fa-star fa-xs"></i>
                        <i class="far fa-star fa-xs"></i>
                        <i class="far fa-star fa-xs"></i>
                        <i class="far fa-star fa-xs"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="recipe-buttons">
        <a href="#"
           title="Add to favorites"><i class="fa fa-heart"></i></a>
        <a href="#" title="Share"><i class="fa fa-share"></i></a>
        <a href="#"
           title="Send E-mail"><i class="fa fa-envelope"></i></a>
        <a href="#"
           title="Add Comment"><i class="fa fa-comment"></i></a>
    </div>
</div>
