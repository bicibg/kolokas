<template>
    <a :class="['btn btn-lg btn-primary btn-base', className]"
       :href="href"
       v-if="href !== undefined && href !== '#' && href.length">
        <slot></slot>
    </a>
    <button :class="['btn btn-lg btn-primary btn-base', className]" :type="role" v-else>
        <slot></slot>
    </button>
</template>
<script>
    export default {
        props: {
            href: {
                type: String,
                default: '#'
            },
            role: {
                type: String,
                default: 'button'
            },
            className: {
                type: String,
                default: ''
            }
        },
    }
</script>
