import './bootstrap';
import './icons';
import './trans';

/**
 * Flash message system using Alpine.js (ships with Livewire).
 * Replaces the former Vue Flash component.
 */
window.flash = function (message, type = 'success') {
    window.dispatchEvent(new CustomEvent('flash', {
        detail: { message, type }
    }));
};

document.addEventListener('livewire:init', () => {
    Livewire.on('flash-success', (params) => {
        if (params.message) {
            flash(params.message, 'success');
        } else if (params.trans_key) {
            flash(__(params.trans_key), 'success');
        }
    });

    Livewire.on('flash-warning', (params) => {
        if (params.message) {
            flash(params.message, 'warning');
        } else if (params.trans_key) {
            flash(__(params.trans_key), 'warning');
        }
    });

    Livewire.on('flash-error', (params) => {
        if (params.message) {
            flash(params.message, 'error');
        } else if (params.trans_key) {
            flash(__(params.trans_key), 'error');
        }
    });
});

/**
 * Register Alpine.js flash component (Alpine is loaded by Livewire).
 */
document.addEventListener('alpine:init', () => {
    Alpine.data('flashMessage', () => ({
        show: false,
        body: '',
        type: 'success',
        timeout: null,

        init() {
            const msg = this.$el.dataset.initialMessage;
            const type = this.$el.dataset.initialType || 'success';
            if (msg) this.flash({ message: msg, type: type });
        },

        flash(data) {
            this.body = data.message;
            this.type = data.type || 'success';
            this.show = true;
            if (this.timeout) clearTimeout(this.timeout);
            this.timeout = setTimeout(() => this.hide(), 10000);
        },

        hide() {
            this.show = false;
            if (this.timeout) clearTimeout(this.timeout);
        },

        get alertClass() {
            return this.type === 'warning' ? 'alert-warning' : (this.type === 'error' ? 'alert-danger' : 'alert-success');
        },

        get prefix() {
            const key = this.type === 'warning' ? 'trx.flash.warning' : (this.type === 'error' ? 'trx.flash.error' : 'trx.flash.success');
            return window.__(key) + '!';
        }
    }));
});

import './custom';
