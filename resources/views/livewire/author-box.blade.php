<div class="recipe-container d-flex flex-column w-100">
    <div class="recipe-content">
        <div class="author-details">
            <h3 class="title text-center">
                <a href="{{ $profile->url }}">{{ $profile->name }}</a> <small>{{ $profile->city }}</small>
            </h3>
        </div>
    </div>
    <div class="recipe-meta text-center">
        @php
            $comments = rand(0, 50);
            $recipes = rand(1, 10)
        @endphp
        <span>
            <i class="fa fa-spoon"></i>
            {{ $recipes }} {{ \Illuminate\Support\Str::plural('recipe', $recipes) }}
        </span>
    </div>
    <div class="recipe-content">
        <div class="author-details">
            <div class="contact">
                <i class="fa fa-envelope-o"></i> <a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a></div>
            <div class="contact">
                <i class="fa fa-globe"></i> <a href="{{ $profile->website }}">{{ $profile->website }}</a></div>
            <div class="contact">
                <i class="fa fa-mobile"></i> <a href="{{ $profile->telephone}}">{{ $profile->telephone}}</a>
            </div>
        </div>
    </div>
    <div class="recipe-buttons">
        <a class="link-facebook" href="#" target="_blank" title="# on Facebook"><i class="fa fa-facebook"></i></a>
        <a class="link-twitter" href="http://www.twitter.com/#" target="_blank" title="@# on Twitter"><i
                class="fa fa-twitter"></i></a>
        <a class="link-linkedin" href="#" target="_blank" title="# on Linkedin"><i class="fa fa-linkedin"></i></a>
        <a class="link-pinterest" href="#" target="_blank" title="# on Pinterest"><i class="fa fa-pinterest-p"></i></a>
    </div>
</div>
