<template>
    <div class="recipe-container d-flex flex-column">
        <div class="recipe-img">
            <img :alt="recipe.title" :src="recipe.images[0].url"
                 height="266" width="400">
            <a :href="recipe.url">
                <div class="hover-button">View Recipe</div>
            </a>
        </div>
        <div class="recipe-meta text-center">
            <span><i class="fa fa-comments"></i>{{comments}} {{'Comment' | pluralize(comments)}}</span>
            <span><i class="fa fa-eye"></i> {{views}} {{'View' | pluralize(views)}}</span>
        </div>
        <div class="recipe-content">
            <h3><a :href="recipe.url">
                {{recipe.title}}
            </a> <small class="text-break">
                {{recipe.description}}
            </small></h3>
        </div>
        <div class="avatar recipe-footer flex-grow-1 d-flex flex-column">
            <div class="flex-grow-1"></div>
            <div class="clearfix">
                <div class="pull-left">
                    <img alt=""
                         class="avatar avatar-25 photo"
                         height="25"
                         src="http://1.gravatar.com/avatar/af8f966d8961c37e29603e8e4fbdd337?s=25&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/af8f966d8961c37e29603e8e4fbdd337?s=50&amp;d=mm&amp;r=g 2x" width="25"> By
                    <a :href="recipe.author.profile.url" rel="author"
                       title="Posts by admin">{{recipe.author.name}}</a></div>
                <span class="user-ratings pull-right">

                    </span>
            </div>
        </div>
        <div class="recipe-buttons">
            <a href="http://themes.ongoingthemes.com/quickrecipe/recipe/spring-cassoulet-with-pistou/?quickrecipe_add_to_favorite=12"
               title="Add to favorites"><i class="fa fa-heart"></i></a>
            <a href="#popup-social12" title="Share"><i class="fa fa-share"></i></a>
            <a href="mailto:?subject=Spring%20Cassoulet%20with%20Pistou&amp;body=Spring%20Cassoulet%20with%20Pistou:http%3A%2F%2Fthemes.ongoingthemes.com%2Fquickrecipe%2Frecipe%2Fspring-cassoulet-with-pistou%2F"
               title="Send E-mail"><i class="fa fa-envelope"></i></a>
            <a href="http://themes.ongoingthemes.com/quickrecipe/recipe/spring-cassoulet-with-pistou/#respond"
               title="Add Comment"><i class="fa fa-comment"></i></a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            recipe: {
                type: Object,
                default: []
            }
        },
        data() {
            return {
                'comments': Math.floor(Math.random() * 50),
                'views': Math.floor(Math.random() * 200),
            }
        },
    }
</script>
