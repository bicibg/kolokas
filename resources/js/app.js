/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap-select');
window.Vue = require('vue');
import $ from 'jquery';
import 'jquery-ui/ui/widgets/slider.js';

window.$ = window.jQuery = $;

if (window.livewire) {
    require('livewire-vue');
}

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.mixin(require('./trans'))

Vue.component('base-button', require('./components/BaseButtonComponent.vue').default);
Vue.component('flash', require('./components/Flash.vue').default);
window.events = new Vue();

window.flash = function (message, type = 'success') {
    window.events.$emit('flash', {message, type});
};

if (window.livewire !== undefined) {
    window.livewire.on('flash-success', (message, trans_key) => {
        if (message) {
            flash(message, 'success');
        } else if (trans_key) {
            flash(__(trans_key), 'success');
        }
    })

    window.livewire.on('flash-warning', (message, trans_key) => {
        if (message) {
            flash(message, 'warning');
        } else if (trans_key) {
            flash(__(trans_key), 'warning');
        }
    })

    window.livewire.on('flash-error', (message, trans_key) => {
        if (message) {
            flash(message, 'error');
        } else if (trans_key) {
            flash(__(trans_key), 'error');
        }
    })

}

const app = new Vue({
    el: '#app',
});

require('./custom')
