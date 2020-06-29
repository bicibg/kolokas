<template>
    <a v-if="href !== undefined && href !== '#' && href.length" :href="href" :class="['btn btn-lg btn-primary btn-base', className]">
        <slot></slot>
    </a>
    <button v-else :class="['btn btn-lg btn-primary btn-base', className]" :type="role">
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
