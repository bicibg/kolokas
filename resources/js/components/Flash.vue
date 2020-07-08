<template>
    <div :class="['alert alert-flash fade show', alertType]" role="alert" v-show="show">
        <strong v-text="alertPrefix"></strong> {{ body }}
        <a class="btn btn-inline" v-on:click="hide()">X</a>
    </div>
</template>

<script>
    export default {
        props: {
            message: {
                type: String,
                default: "",
            },
            type: {
                type: String,
                default: "success"
            }
        },
        data() {
            return {
                body: this.message,
                show: false,
                internal_type: this.type,
                timeout: null,
            }
        },
        created() {
            if (this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message => {
                if (message instanceof String) {
                    this.flash(message);
                } else if (message instanceof Object) {
                    this.internal_type = message.type;
                    this.flash(message.message, message.type);
                }
            });

        },
        methods: {
            flash(message) {
                this.body = message;
                this.show = true;
                this.timeout = setTimeout(() => {
                    this.hide();
                }, 10000)
            },
            hide() {
                this.show = false;
                if (this.timeout) {
                    clearTimeout(this.timeout);
                }
            },

        },
        computed: {
            alertType: function () {
                switch (this.internal_type) {
                    case 'warning':
                        return 'alert-warning';
                    case 'error':
                        return 'alert-danger';
                    case 'success':
                    default:
                        return 'alert-success';

                }
            },
            alertPrefix: function () {
                switch (this.internal_type) {
                    case 'warning':
                        return 'Warning!';
                    case 'error':
                        return 'Ooops!';
                    case 'success':
                    default:
                        return 'Success!';

                }
            },
        },
    }
</script>
