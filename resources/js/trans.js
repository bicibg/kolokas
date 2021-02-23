window.__ = function __(key, replace) {
    let translation, translationNotFound = true

    try {
        translation = key.split('.').reduce((t, i) => t[i] || null, window._translations[window._locale].php)

        if (translation) {
            translationNotFound = false
        }
    } catch (e) {
        translation = key
    }

    if (translationNotFound) {
        translation = window._translations[window._locale]['json'][key]
            ? window._translations[window._locale]['json'][key]
            : key
    }

    _.forEach(replace, (value, key) => {
        translation = translation.replace(':' + key, value)
    })

    return translation
}

var translationsDone = 0;
var maxTranslations = 24;
window.gtranslate = function gtranslate(from, to, context) {
    let fromEl = document.getElementById(context + '_' + from);
    let toEl = document.getElementById(context + '_' + to);

    if (!fromEl.value.length) {
        flash(__('trx.translation_source_missing', {source: __('recipe.' + context)}), 'error')
        return;
    }
    if (toEl.value.length) {
        flash(__('trx.translation_target_filled', {target: __('recipe.' + context)}), 'error')
        return;
    }
    if (translationsDone >= maxTranslations) {
        flash(__('trx.translation_limit_reached'), 'error')
        return;
    }
    if (fromEl.value.length && !toEl.value.length && translationsDone < maxTranslations) {
        axios.post('/translate', {
            text: fromEl.value,
            to: to
        }).then(({data}) => {
            translationsDone++;
            toEl.value = data.text;
            toEl.dispatchEvent(new Event('input'));
        });
    }
}

module.exports = {
    methods: {
        /**
         * Translate the given key.
         */
        __(key, replace) {
            return __(key, replace);
        },
        gtranslate(from, to) {
            return gtranslate(from, to);
        }
    },
}
