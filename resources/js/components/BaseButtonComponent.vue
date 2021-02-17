<template>
    <a :class="['btn btn-lg btn-primary btn-base', className]"
       :href="href"
       v-if="href !== undefined && href !== '#' && href.length">
        <slot></slot>
    </a>
    <button :class="['btn btn-lg btn-primary btn-base', className]" :type="role" :disabled="isDisabled" v-else>
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
        isDisabled(){
            return this.internal_disabled;
        }
    },
}
</script>
