<template>
    <div class="recipe-box-container d-flex flex-column">
        <div class="recipe-box-img">
            <img width="400" height="266"
                 src="https://picsum.photos/500" :alt="user.title">
                    <a :href="user.url">
                        <div class="hover-button">View Recipe</div>
                    </a>
        </div>
        <div class="recipe-box-meta">
            <span><i class="fa fa-spoon"></i> {{recipes}} {{'Recipe' | pluralize(recipes)}}</span>
            <span><i class="fa fa-comment-o"></i> {{comments}} {{'Comment' | pluralize(comments)}}</span>
        </div>
        <div class="recipe-box-content">
            <div class="author-details">
                <h3 class="title"><a href="#">{{user.name}}</a> <small>Girne</small></h3>
                <div class="contact">
                    <i class="fa fa-envelope-o"></i><a :href="'mailto:'+user.email">{{ user.email }}</a></div>
                <div class="contact">
                    <i class="fa fa-globe"></i><a href="http://www.example.com">http://www.example.com</a></div>
                <div class="contact">
                    <i class="fa fa-mobile"></i>0090 533 860 8693</div>
            </div>
        </div>
        <div class="recipe-box-buttons">
            <a class="link-facebook" target="_blank" title="# on Facebook" href="#"><i class="fa fa-facebook"></i></a>
            <a class="link-twitter" target="_blank" title="@# on Twitter" href="http://www.twitter.com/#"><i class="fa fa-twitter"></i></a>
            <a class="link-linkedin" target="_blank" title="# on Linkedin" href="#"><i class="fa fa-linkedin"></i></a>
            <a class="link-pinterest" target="_blank" title="# on Pinterest" href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: {
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
        mounted() {
            console.log(this.user);
            console.log('Component mounted.')
        },
    }
</script>
