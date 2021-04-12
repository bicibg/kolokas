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
window.gtranslate = function gtranslate(from, to, context, self) {
    var buttons = document.getElementsByClassName("translate-btn"),
        len = buttons !== null ? buttons.length : 0;
    for(let i=0; i < len; i++) {
        buttons[i].classList.remove('disabled');
        buttons[i].classList.add('disabled');
    }

    self.querySelector('.spinner').classList.remove('hidden');
    let fromEl = document.getElementById(context + '_' + from);
    let toEl = document.getElementById(context + '_' + to);

    if (!fromEl.value.length) {
        const contextName = __('trx.' + context);
        flash(__('trx.translation_source_missing', {source: contextName}), 'error')
        self.querySelector('.spinner').classList.add('hidden');
        for(let i=0; i < len; i++) {
            buttons[i].classList.remove('disabled');
        }
        return;
    }
    if (toEl.value.length) {
        const contextName = __('trx.' + context);
        flash(__('trx.translation_target_filled', {target: contextName}), 'error')
        self.querySelector('.spinner').classList.add('hidden');
        for(let i=0; i < len; i++) {
            buttons[i].classList.remove('disabled');
        }
        return;
    }
    if (translationsDone >= maxTranslations) {
        flash(__('trx.translation_limit_reached'), 'error')
        self.querySelector('.spinner').classList.add('hidden');
        for(let i=0; i < len; i++) {
            buttons[i].classList.remove('disabled');
        }
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
            self.querySelector('.spinner').classList.add('hidden');
            for(let i=0; i < len; i++) {
                buttons[i].classList.remove('disabled');
            }
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
