<template>
    <a v-if="href !== undefined && href !== '#' && href.length" :href="href" :class="['btn btn-lg btn-primary btn-base']">
        <slot></slot>
    </a>
    <button v-else :class="['btn btn-lg btn-primary btn-base']" :type="role">
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
            }
        },
    }
</script>
