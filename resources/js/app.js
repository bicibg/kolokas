/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import './icons';
import 'bootstrap-select';
import Vue from 'vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

import trans from './trans';
import BaseButtonComponent from './components/BaseButtonComponent.vue';
import Flash from './components/Flash.vue';

Vue.mixin(trans);
Vue.component('base-button', BaseButtonComponent);
Vue.component('flash', Flash);
window.events = new Vue();

window.flash = function (message, type = 'success') {
    window.events.$emit('flash', {message, type});
};

document.addEventListener('livewire:init', () => {
    Livewire.on('flash-success', (params) => {
        if (params.message) {
            flash(params.message, 'success');
        } else if (params.trans_key) {
            flash(__(params.trans_key), 'success');
        }
    })

    Livewire.on('flash-warning', (params) => {
        if (params.message) {
            flash(params.message, 'warning');
        } else if (params.trans_key) {
            flash(__(params.trans_key), 'warning');
        }
    })

    Livewire.on('flash-error', (params) => {
        if (params.message) {
            flash(params.message, 'error');
        } else if (params.trans_key) {
            flash(__(params.trans_key), 'error');
        }
    })
});

const app = new Vue({
    el: '#app',
});

import './custom';
