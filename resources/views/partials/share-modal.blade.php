<div class="modal fade popup" id="popup-social-{{ $recipe->slug }}" tabindex="-1" role="dialog"
     aria-labelledby="popup-social-{{ $recipe->slug }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{ __('recipe.share') }}</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>{{ $recipe->title }}</p>
                <div class="social-content">
                    <ul class="social-icons">
                        <li>
                            <a class="email"
                               href="mailto:?subject={{ urlencode($recipe->title) }}&amp;body={{ urlencode($recipe->description . ': ' . $recipe->url) }}"
                               target="_blank">
                                <i class="fa fa-envelope"></i>
                            </a>
                        </li>
                        <li>
                            <a class="twitter"
                               href="https://twitter.com/intent/tweet?text={{ urlencode($recipe->title) }}&amp;url={{ $recipe->url }}"
                               target="_blank">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a class="facebook"
                               href="https://www.facebook.com/sharer/sharer.php?u={{ $recipe->url }}"
                               target="_blank">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a class="whatsapp"
                               {{--                               href="whatsapp://send?{{ urlencode($recipe->description . ': ' . $recipe->url) }}"--}}
                               href="https://api.whatsapp.com/send?text={{ urlencode($recipe->description . ': ' . $recipe->url) }}"
                               data-action="share/whatsapp/share"
                               target="_blank">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                        </li>
                        <li><a class="linkedin"
                               href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ $recipe->url }}&amp;title={{ $recipe->title }}"
                               target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        <li><a class="pinterest"
                               href="https://pinterest.com/pin/create/button/?url={{ $recipe->url }}&amp;media={{ $recipe->mainImage->url }}&amp;description={{ $recipe->title }}"
                               target="_blank">
                                <i class="fa fa-pinterest"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
