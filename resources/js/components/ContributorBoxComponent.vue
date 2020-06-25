<template>
    <div class="recipe-container d-flex flex-column">
        <div class="recipe-img">
            <img :alt="profile.name" :src="profile.photo"
                 height="266" width="400">
            <a :href="profile.url">
                <div class="hover-button">View Author</div>
            </a>
        </div>
        <div class="recipe-meta text-center">
            <span><i class="fa fa-spoon"></i> {{recipes}} {{'Recipe' | pluralize(recipes)}}</span>
            <span><i class="fa fa-comment-o"></i> {{comments}} {{'Comment' | pluralize(comments)}}</span>
        </div>
        <div class="recipe-content">
            <div class="author-details">
                <h3 class="title"><a :href="profile.url">{{profile.name}}</a> <small>{{ profile.city }}</small></h3>
                <div class="contact">
                    <i class="fa fa-envelope-o"></i><a :href="'mailto:'+profile.email">{{ profile.email }}</a></div>
                <div class="contact">
                    <i class="fa fa-globe"></i><a :href="profile.website">{{ profile.website }}</a></div>
                <div class="contact">
                    <i class="fa fa-mobile"></i>{{ profile.telephone}}
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
</template>

<script>
    export default {
        props: {
            profile: {
                type: Object,
                default: []
            }
        },
        data() {
            return {
                'comments': Math.floor(Math.random() * 50),
                'recipes': Math.floor(Math.random() * 10),
            }
        },
    }
</script>
