<template>
    <div class="recipe-box-container d-flex flex-column">
        <div class="recipe-box-img">
            <img width="400" height="266"
                 :src="recipe.images[0].url" :alt="recipe.title">
                    <a :href="recipe.url">
                        <div class="hover-button">View Recipe</div>
                    </a>
        </div>
        <div class="recipe-box-meta">
            <span><i class="fa fa-comments"></i>{{comments}} {{'Comment' | pluralize(comments)}}</span>
            <span><i class="fa fa-eye"></i> {{views}} {{'View' | pluralize(views)}}</span>
            <span><i class="fa fa-folder"></i> None</span>
        </div>
        <div class="recipe-box-content">
            <h3><a :href="recipe.url">
                {{recipe.title}}
            </a> <small>
                {{recipe.description}}
            </small></h3>
        </div>
        <div class="avatar recipe-box-footer flex-grow-1 d-flex flex-column">
            <div class="flex-grow-1"></div>
            <div class="clearfix">
                <div class="pull-left">
                    <img alt=""
                         src="http://1.gravatar.com/avatar/af8f966d8961c37e29603e8e4fbdd337?s=25&amp;d=mm&amp;r=g"
                         srcset="http://1.gravatar.com/avatar/af8f966d8961c37e29603e8e4fbdd337?s=50&amp;d=mm&amp;r=g 2x"
                         class="avatar avatar-25 photo" height="25" width="25"> By <a
                    :href="recipe.author.url" title="Posts by admin"
                    rel="author">{{recipe.author.name}}</a></div>
                <span class="user-ratings pull-right">

                    </span>
            </div>
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
        mounted() {
            console.log(this.recipe);
            console.log('Component mounted.')
        },
    }
</script>
