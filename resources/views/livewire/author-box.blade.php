<div class="recipe-container d-flex flex-column w-100">
    @if($profile->is_pro)
        <span class="badge badge-pill position-absolute pro-badge text-light">PRO</span>
    @endif
    <div class="recipe-content">
        <div class="author-details">
            <h3 class="title text-center">
                <a href="{{ $profile->url }}">{{ $profile->name }}</a>
                @if ($profile->city)
                    <small>{{ $profile->city }}</small>
                @endif
            </h3>
        </div>
    </div>
    <div class="recipe-meta text-center">
        @php
            $recipes = rand(1, 10)
        @endphp
        <span>
            <i class="fa fa-spoon"></i>
            {{ $profile->user->recipes->count() }} {{ trans_choice('trx.recipe', $profile->user->recipes->count()) }}
        </span>
    </div>
    <div class="recipe-content">
        <div class="author-details">
            <div class="contact">
                <i class="fa fa-envelope-o"></i>
                @if (\Illuminate\Support\Str::contains($profile->email, 'kolokas@gmail.com'))
                    <note>{{ __('trx.author_email_hidden') }}</note>
                @else
                    <a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>
                @endif
            </div>
            @if ($profile->website)
                <div class="contact">
                    <i class="fa fa-globe"></i> <a href="{{ $profile->website }}">{{ $profile->website }}</a>
                </div>
            @endif
            @if ($profile->telephone)
                <div class="contact">
                    <i class="fa fa-mobile"></i> <a href="{{ $profile->telephone}}">{{ $profile->telephone}}</a>
                </div>
            @endif
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
