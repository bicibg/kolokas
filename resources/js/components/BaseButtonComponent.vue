<template>
    <a v-if="href !== undefined && href !== '#' && href.length"
       :class="['btn btn-lg btn-primary btn-base', className]"
       :href="href">
        <slot></slot>
    </a>
    <button v-else :class="['btn btn-lg btn-primary btn-base', className]" :disabled="isDisabled" :type="role">
        <slot></slot>
    </button>
</template>
<script>
export default {
    props: {
        disabled: {
            type: [Number, String],
            default: 0
        },
        href: {
            type: String,
            default: '#'
        },
        props: {},
        role: {
            type: String,
            default: 'button'
        },
        className: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            internal_disabled: !!this.disabled,
        }
    },
    computed: {
        isDisabled() {
            return this.internal_disabled;
        }
    },
}
</script>
