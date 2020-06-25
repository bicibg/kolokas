<template>
    <a :class="['btn btn-lg btn-primary btn-base', classProp.length ? ' ' + classProp : '']" :href="hrefProp" :role="roleProp">
        <slot></slot>
    </a>
</template>
<script>
    export default {
        props: {
            hrefProp: {
                type: String,
                default: '#'
            },
            classProp: {
                type: String,
                default: ''
            },
            roleProp: {
                type: String,
                default: 'button'
            }
        },
    }
</script>
