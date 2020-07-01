@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 single-post">
                <div id="single-content" class="inner-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="recipe active">
                                        @include('recipe.partial.carousel')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="recipe-meta w-100 mb-5">
                            <div class="recipe-buttons no-print">
                                @livewire('favourite', ['recipe' => $recipe])
                                <a href="javascript:void(0);"
                                   title="Add Comment">
                                    <i class="fa fa-comment"></i>
                                    <span class="d-inline-block">
                                        {{ 0 }} {{ \Illuminate\Support\Str::plural('comment', 0) }}
                                    </span>
                                </a>
                                <a data-toggle="modal"
                                   href="javascript:void(0);"
                                   data-target="#popup-social-{{ $recipe->slug }}"
                                   title="Share">
                                    <i class="fa fa-share"></i>
                                    <span class="d-inline-block">
                                        Share
                                    </span>
                                </a>
                                <a href="javascript:void(0);"
                                   rel="nofollow"
                                   onclick="window.print(); return false;"
                                   title="Printer Friendly, PDF &amp; Email">
                                    <i class="fa fa-print"></i>
                                    <span class="d-inline-block">
                                        Print / PDF
                                    </span>
                                </a>
                            </div>
                            <ul class="print-only">

                                <li>Prep Time<strong>
                                        <i class="fa fa-clock-o"></i> {{ \Illuminate\Support\Str::plural($recipe->prep_time, 'minute') }}
                                    </strong></li>
                                <li>Cook Time<strong>
                                        <i class="fa fa-clock-o"></i> {{ \Illuminate\Support\Str::plural($recipe->cook_time, 'minute') }}
                                    </strong></li>
                                <li>Serving<strong>
                                        For {{ $recipe->servings }} </strong></li>
                            </ul>

                        </div>


                        {{--                            --}}
                        {{--                            <div class="button-box">--}}
                        {{--                                <div class="printfriendly"><a href="#" style="outline:none;" rel="nofollow"--}}
                        {{--                                                              onclick="window.print(); return false;" class="noslimstat"--}}
                        {{--                                                              title="Printer Friendly, PDF &amp; Email"><i--}}
                        {{--                                            class="fa fa-print"></i> Print</a></div>--}}
                        {{--                                <a href="mailto:?subject={{ urlencode($recipe->title) }}&amp;body={{ urlencode($recipe->description) }}: {{ $recipe->url }}"--}}
                        {{--                                   class="email"><i class="fa fa-envelope"></i> E-mail</a>--}}
                        {{--                                <form method="post" class="favorite_user_post" action="#">--}}
                        {{--                                    <button type="submit" name="quickrecipe_add_to_favorite" value="17"--}}
                        {{--                                            class="btn-success">--}}
                        {{--                                        <i class="fa fa-heart"></i> Favorite--}}
                        {{--                                    </button>--}}
                        {{--                                </form>--}}
                        {{--                            </div>--}}
                        <div class="clearfix"></div>

                        <div>
                            <h3 class="section-title">Recipe Description</h3>
                            <div>
                                <p>
                                    {{ $recipe->description }}
                                </p>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <h3 class="section-title">Recipe Ingredient</h3>
                                    <div class="ingredients-list print-only">
                                        <ul class="ingredient-check">
                                            @foreach($recipe->ingredients as $ingredient)
                                                <li>
                                                    <span class="no-print">
                                                        <input type="checkbox" value="">
                                                    </span>
                                                    {{ $ingredient }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="directions print-only">
                                        <!-- Directions -->
                                        <h3 class="section-title">Instructions</h3>
                                        <div class="instructions">
                                            <ol>
                                                @foreach($recipe->instructions as $instruction)
                                                    <li>
                                                        {{ $instruction }}
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('partials.share-modal')
                        </div>
                    </div>
                </div>
            </div>
            <div class="no-print">
                <div>
                    <div>
                        <h3 class="section-title">You may also like</h3>
                        <div class="row">

                            @foreach($othersYouMaylike as $recipe)
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    @livewire('recipe-box', ['recipe'=>$recipe])
                                </div>
                            @endforeach
                        </div>
                        {{--
                                     <div class="navigation post-navigation clearfix">
                                         <div class="alignleft post-nav-links prev-link-wrapper">

                                             <a href="http://themes.ongoingthemes.com/quickrecipe/recipe/pear-arugula-and-pancetta-salad/" title="Previous Recipe: Pear, Arugula, and Pancetta Salad" rel="prev"><div class="prev-link"><span>Previous Recipe:</span> Pear, Arugula, and Pancetta Salad</div></a>
                                         </div>
                                         <div class="alignright post-nav-links next-link-wrapper">

                                             <a href="http://themes.ongoingthemes.com/quickrecipe/recipe/baked-garlic-and-chilli-prawn/" title="Next Recipe: Baked Garlic and Chilli Prawn" rel="next"><div class="next-link"><span>Next Recipe:</span> Baked Garlic and Chilli Prawn</div></a>

                                         </div>
                                     </div><!-- end .navigation -->
                                     <div id="comments" class="comments-area">

                                         <h2 class="comments-title">
                                             3 thoughts on “Pea And Halloumi Fritters”		</h2>


                                         <ol class="comment-list">
                                             <li id="comment-3">
                                                 <div class="comment">
                                                     <div class="comment-avatar">
                                                         <img alt="" src="http://0.gravatar.com/avatar/9e6afdc7b7b9bfd0ba64c4a0e56a1918?s=96&amp;d=mm&amp;r=g" srcset="http://0.gravatar.com/avatar/9e6afdc7b7b9bfd0ba64c4a0e56a1918?s=192&amp;d=mm&amp;r=g 2x" class="avatar avatar-96 photo" height="96" width="96">            </div>
                                                     <div class="comment-body">
                                                         <span class="comment-author">Michael Jonas -</span> <span class="comment-date">May 17, 2016 at 4:08 pm</span>
                                                         <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                                         <a rel="nofollow" class="comment-reply-link" href="http://themes.ongoingthemes.com/quickrecipe/recipe/pea-mint-and-haloumi-fritters-with-tomato/?replytocom=3#respond" data-commentid="3" data-postid="17" data-belowelement="comment-3" data-respondelement="respond" aria-label="Reply to Michael Jonas">Reply</a>            </div>
                                                 </div>

                                             </li><!-- #comment-## -->
                                             <li id="comment-4">
                                                 <div class="comment">
                                                     <div class="comment-avatar">
                                                         <img alt="" src="http://0.gravatar.com/avatar/030dd03dbc047dab6ed5e25a5dd398d4?s=96&amp;d=mm&amp;r=g" srcset="http://0.gravatar.com/avatar/030dd03dbc047dab6ed5e25a5dd398d4?s=192&amp;d=mm&amp;r=g 2x" class="avatar avatar-96 photo" height="96" width="96">            </div>
                                                     <div class="comment-body">
                                                         <span class="comment-author">Anrew Brown -</span> <span class="comment-date">May 17, 2016 at 4:12 pm</span>
                                                         <p>Very easy and tasty.   Overall a great fast recipe that would be perfect for picnics!</p>
                                                         <a rel="nofollow" class="comment-reply-link" href="http://themes.ongoingthemes.com/quickrecipe/recipe/pea-mint-and-haloumi-fritters-with-tomato/?replytocom=4#respond" data-commentid="4" data-postid="17" data-belowelement="comment-4" data-respondelement="respond" aria-label="Reply to Anrew Brown">Reply</a>            </div>
                                                 </div>

                                             </li><!-- #comment-## -->
                                             <li id="comment-5">
                                                 <div class="comment">
                                                     <div class="comment-avatar">
                                                         <img alt="" src="http://2.gravatar.com/avatar/5c3264d61d04dc96242afc308d2081c4?s=96&amp;d=mm&amp;r=g" srcset="http://2.gravatar.com/avatar/5c3264d61d04dc96242afc308d2081c4?s=192&amp;d=mm&amp;r=g 2x" class="avatar avatar-96 photo" height="96" width="96">            </div>
                                                     <div class="comment-body">
                                                         <span class="comment-author">Kevin Thomas -</span> <span class="comment-date">May 21, 2016 at 8:24 pm</span>
                                                         <div class="user-ratings"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
                                                         <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                                         <a rel="nofollow" class="comment-reply-link" href="http://themes.ongoingthemes.com/quickrecipe/recipe/pea-mint-and-haloumi-fritters-with-tomato/?replytocom=5#respond" data-commentid="5" data-postid="17" data-belowelement="comment-5" data-respondelement="respond" aria-label="Reply to Kevin Thomas">Reply</a>            </div>
                                                 </div>

                                             </li><!-- #comment-## -->
                                         </ol><!-- .comment-list -->




                                         <div id="respond" class="comment-respond">
                                             <h2 id="reply-title" class="comment-reply-title">Leave a Reply <small><a rel="nofollow" id="cancel-comment-reply-link" href="/quickrecipe/recipe/pea-mint-and-haloumi-fritters-with-tomato/#respond" style="display:none;">Cancel reply</a></small></h2><form action="http://themes.ongoingthemes.com/quickrecipe/wp-comments-post.php" method="post" id="commentform" class="comment-form"><p class="logged-in-as"><a href="http://themes.ongoingthemes.com/quickrecipe/wp-admin/profile.php" aria-label="Logged in as hkh. Edit your profile.">Logged in as hkh</a>. <a href="http://themes.ongoingthemes.com/quickrecipe/wp-login.php?action=logout&amp;redirect_to=http%3A%2F%2Fthemes.ongoingthemes.com%2Fquickrecipe%2Frecipe%2Fpea-mint-and-haloumi-fritters-with-tomato%2F&amp;_wpnonce=29a4024a08">Log out?</a></p><p class="comment-form-rating"><label>Rating <span class="required">*</span></label>
                                                     <span class="star-cb-group"><input type="radio" id="rating-0" name="rating" value="0" class="star-cb-clear"><label for="rating-0">0</label><input type="radio" id="rating-5" name="rating" value="5"><label for="rating-5">5</label><input type="radio" id="rating-4" name="rating" value="4"><label for="rating-4">4</label><input type="radio" id="rating-3" name="rating" value="3"><label for="rating-3">3</label><input type="radio" id="rating-2" name="rating" value="2"><label for="rating-2">2</label><input type="radio" id="rating-1" name="rating" value="1"><label for="rating-1">1</label></span></p><p class="comment-form-comment"><label for="comment">Comment</label> <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p><p class="form-submit"><input name="submit" type="submit" id="submit" class="submit" value="Post Comment"> <input type="hidden" name="comment_post_ID" value="17" id="comment_post_ID">
                                                     <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                                                 </p></form>	</div><!-- #respond -->

                                     </div><!-- .comments-area -->

         --}}
                    </div>

                </div>

                <!-- break -->
            </div>
        </div>
    </div>
    </div>
@endsection
