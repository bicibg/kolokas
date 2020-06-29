<template>
    <div :class="['alert alert-flash fade show', alertType]" role="alert" v-show="show">
        <strong v-text="alertPrefix"></strong> {{ body }}
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
                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 5000)
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

<style>
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>
