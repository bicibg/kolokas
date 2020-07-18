<div class="search my-3">
    <form method="get" class="search-form" action="{{ $action ?? route('recipe.index') }}">

    <div class="basic-search">
        <div class="input-field position-relative">
            <div class="icon-wrap">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20">
                    <path d="M18.869 19.162l-5.943-6.484c1.339-1.401 2.075-3.233 2.075-5.178 0-2.003-0.78-3.887-2.197-5.303s-3.3-2.197-5.303-2.197-3.887 0.78-5.303 2.197-2.197 3.3-2.197 5.303 0.78 3.887 2.197 5.303 3.3 2.197 5.303 2.197c1.726 0 3.362-0.579 4.688-1.645l5.943 6.483c0.099 0.108 0.233 0.162 0.369 0.162 0.121 0 0.242-0.043 0.338-0.131 0.204-0.187 0.217-0.503 0.031-0.706zM1 7.5c0-3.584 2.916-6.5 6.5-6.5s6.5 2.916 6.5 6.5-2.916 6.5-6.5 6.5-6.5-2.916-6.5-6.5z"></path>
                </svg>
            </div>
            <input id="search" type="text" name="s" value="{{ request()->get('s') }}" placeholder="{{ __('general.search') }}...">
            <div class="result-count">
                <span>{{ $recipesCount }} </span>{{ trans_choice('recipe.recipe', $recipesCount) }}</div>
        </div>
    </div>
    {{--<div class="advance-search">
        <span class="desc">Advanced Search</span>
        <div class="row">
            <div class="input-field">
                <div class="input-select">
                    <div class="choices invalid" role="listbox" data-type="select-one" tabindex="0" aria-haspopup="true" aria-expanded="false" dir="ltr" aria-activedescendant="choices-choices-single-defaul-7s-item-choice-1">
                        <div class="choices__inner"><select data-trigger="" name="choices-single-defaul" class="choices__input is-hidden" tabindex="-1" style="display:none;" aria-hidden="true" data-choice="active"><option value="" selected="">ACCESSORIES</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable choices__placeholder" data-item="" data-id="4" data-value="" data-deletable="" aria-selected="true">
                                    ACCESSORIES<!--
           --><button type="button" class="choices__button" data-button="" aria-label="Remove item: ''">
                                        Remove item
                                    </button>
                                </div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false">
                            <div class="choices__list" dir="ltr" role="listbox"><div class="choices__item choices__item--choice choices__item--selectable choices__placeholder is-highlighted" data-select-text="" data-choice="" data-id="1" data-value="" data-choice-selectable="" id="choices-choices-single-defaul-7s-item-choice-1" role="option" aria-selected="true">
                                    ACCESSORIES
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="2" data-value="ACCESSORIES" data-choice-selectable="" id="choices-choices-single-defaul-7s-item-choice-2" role="option">
                                    ACCESSORIES
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="3" data-value="SUBJECT B" data-choice-selectable="" id="choices-choices-single-defaul-7s-item-choice-3" role="option">
                                    SUBJECT B
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="4" data-value="SUBJECT C" data-choice-selectable="" id="choices-choices-single-defaul-7s-item-choice-4" role="option">
                                    SUBJECT C
                                </div></div></div></div>
                </div>
            </div>
            <div class="input-field">
                <div class="input-select">
                    <div class="choices invalid" role="listbox" data-type="select-one" tabindex="0" aria-haspopup="true" aria-expanded="false" dir="ltr" aria-activedescendant="choices-choices-single-defaul-fu-item-choice-1">
                        <div class="choices__inner"><select data-trigger="" name="choices-single-defaul" class="choices__input is-hidden" tabindex="-1" style="display:none;" aria-hidden="true" data-choice="active"><option value="" selected="">COLOR</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable choices__placeholder" data-item="" data-id="4" data-value="" data-deletable="" aria-selected="true">
                                    COLOR<!--
           --><button type="button" class="choices__button" data-button="" aria-label="Remove item: ''">
                                        Remove item
                                    </button>
                                </div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false">
                            <div class="choices__list" dir="ltr" role="listbox"><div class="choices__item choices__item--choice choices__item--selectable choices__placeholder is-highlighted" data-select-text="" data-choice="" data-id="1" data-value="" data-choice-selectable="" id="choices-choices-single-defaul-fu-item-choice-1" role="option" aria-selected="true">
                                    COLOR
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="2" data-value="GREEN" data-choice-selectable="" id="choices-choices-single-defaul-fu-item-choice-2" role="option">
                                    GREEN
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="3" data-value="SUBJECT B" data-choice-selectable="" id="choices-choices-single-defaul-fu-item-choice-3" role="option">
                                    SUBJECT B
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="4" data-value="SUBJECT C" data-choice-selectable="" id="choices-choices-single-defaul-fu-item-choice-4" role="option">
                                    SUBJECT C
                                </div></div></div></div>
                </div>
            </div>
            <div class="input-field">
                <div class="input-select">
                    <div class="choices invalid" role="listbox" data-type="select-one" tabindex="0" aria-haspopup="true" aria-expanded="false" dir="ltr" aria-activedescendant="choices-choices-single-defaul-rv-item-choice-1">
                        <div class="choices__inner"><select data-trigger="" name="choices-single-defaul" class="choices__input is-hidden" tabindex="-1" style="display:none;" aria-hidden="true" data-choice="active"><option value="" selected="">SIZE</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable choices__placeholder" data-item="" data-id="4" data-value="" data-deletable="" aria-selected="true">
                                    SIZE<!--
           --><button type="button" class="choices__button" data-button="" aria-label="Remove item: ''">
                                        Remove item
                                    </button>
                                </div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false">
                            <div class="choices__list" dir="ltr" role="listbox"><div class="choices__item choices__item--choice choices__item--selectable choices__placeholder is-highlighted" data-select-text="" data-choice="" data-id="1" data-value="" data-choice-selectable="" id="choices-choices-single-defaul-rv-item-choice-1" role="option" aria-selected="true">
                                    SIZE
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="2" data-value="SIZE" data-choice-selectable="" id="choices-choices-single-defaul-rv-item-choice-2" role="option">
                                    SIZE
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="3" data-value="SUBJECT B" data-choice-selectable="" id="choices-choices-single-defaul-rv-item-choice-3" role="option">
                                    SUBJECT B
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="4" data-value="SUBJECT C" data-choice-selectable="" id="choices-choices-single-defaul-rv-item-choice-4" role="option">
                                    SUBJECT C
                                </div></div></div></div>
                </div>
            </div>
        </div>
        <div class="row second">
            <div class="input-field">
                <div class="input-select">
                    <div class="choices invalid" role="listbox" data-type="select-one" tabindex="0" aria-haspopup="true" aria-expanded="false" dir="ltr" aria-activedescendant="choices-choices-single-defaul-u9-item-choice-1">
                        <div class="choices__inner"><select data-trigger="" name="choices-single-defaul" class="choices__input is-hidden" tabindex="-1" style="display:none;" aria-hidden="true" data-choice="active"><option value="" selected="">SALE</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable choices__placeholder" data-item="" data-id="4" data-value="" data-deletable="" aria-selected="true">
                                    SALE<!--
           --><button type="button" class="choices__button" data-button="" aria-label="Remove item: ''">
                                        Remove item
                                    </button>
                                </div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false">
                            <div class="choices__list" dir="ltr" role="listbox"><div class="choices__item choices__item--choice choices__item--selectable choices__placeholder is-highlighted" data-select-text="" data-choice="" data-id="1" data-value="" data-choice-selectable="" id="choices-choices-single-defaul-u9-item-choice-1" role="option" aria-selected="true">
                                    SALE
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="2" data-value="SALE" data-choice-selectable="" id="choices-choices-single-defaul-u9-item-choice-2" role="option">
                                    SALE
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="3" data-value="SUBJECT B" data-choice-selectable="" id="choices-choices-single-defaul-u9-item-choice-3" role="option">
                                    SUBJECT B
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="4" data-value="SUBJECT C" data-choice-selectable="" id="choices-choices-single-defaul-u9-item-choice-4" role="option">
                                    SUBJECT C
                                </div></div></div></div>
                </div>
            </div>
            <div class="input-field">
                <div class="input-select">
                    <div class="choices invalid" role="listbox" data-type="select-one" tabindex="0" aria-haspopup="true" aria-expanded="false" dir="ltr" aria-activedescendant="choices-choices-single-defaul-2r-item-choice-4">
                        <div class="choices__inner"><select data-trigger="" name="choices-single-defaul" class="choices__input is-hidden" tabindex="-1" style="display:none;" aria-hidden="true" data-choice="active"><option value="" selected="">TIME</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable choices__placeholder" data-item="" data-id="4" data-value="" data-deletable="" aria-selected="true">
                                    TIME<!--
           --><button type="button" class="choices__button" data-button="" aria-label="Remove item: ''">
                                        Remove item
                                    </button>
                                </div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false">
                            <div class="choices__list" dir="ltr" role="listbox"><div class="choices__item choices__item--choice choices__item--selectable choices__placeholder is-highlighted" data-select-text="" data-choice="" data-id="4" data-value="" data-choice-selectable="" id="choices-choices-single-defaul-2r-item-choice-4" role="option" aria-selected="true">
                                    TIME
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="1" data-value="SUBJECT B" data-choice-selectable="" id="choices-choices-single-defaul-2r-item-choice-1" role="option">
                                    SUBJECT B
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="2" data-value="SUBJECT C" data-choice-selectable="" id="choices-choices-single-defaul-2r-item-choice-2" role="option">
                                    SUBJECT C
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="3" data-value="THIS WEEK" data-choice-selectable="" id="choices-choices-single-defaul-2r-item-choice-3" role="option">
                                    THIS WEEK
                                </div></div></div></div>
                </div>
            </div>
            <div class="input-field">
                <div class="input-select">
                    <div class="choices invalid" role="listbox" data-type="select-one" tabindex="0" aria-haspopup="true" aria-expanded="false" dir="ltr" aria-activedescendant="choices-choices-single-defaul-s3-item-choice-3">
                        <div class="choices__inner"><select data-trigger="" name="choices-single-defaul" class="choices__input is-hidden" tabindex="-1" style="display:none;" aria-hidden="true" data-choice="active"><option value="" selected="">TYPE</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable choices__placeholder" data-item="" data-id="4" data-value="" data-deletable="" aria-selected="true">
                                    TYPE<!--
           --><button type="button" class="choices__button" data-button="" aria-label="Remove item: ''">
                                        Remove item
                                    </button>
                                </div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false">
                            <div class="choices__list" dir="ltr" role="listbox"><div class="choices__item choices__item--choice choices__item--selectable choices__placeholder is-highlighted" data-select-text="" data-choice="" data-id="3" data-value="" data-choice-selectable="" id="choices-choices-single-defaul-s3-item-choice-3" role="option" aria-selected="true">
                                    TYPE
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="1" data-value="SUBJECT B" data-choice-selectable="" id="choices-choices-single-defaul-s3-item-choice-1" role="option">
                                    SUBJECT B
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="2" data-value="SUBJECT C" data-choice-selectable="" id="choices-choices-single-defaul-s3-item-choice-2" role="option">
                                    SUBJECT C
                                </div><div class="choices__item choices__item--choice choices__item--selectable" data-select-text="" data-choice="" data-id="4" data-value="TYPE" data-choice-selectable="" id="choices-choices-single-defaul-s3-item-choice-4" role="option">
                                    TYPE
                                </div></div></div></div>
                </div>
            </div>
        </div>
        <div class="row third">
            <div class="input-field">
                <button class="btn-search">Search</button>
                <button class="btn-delete" id="delete">Delete</button>
            </div>
        </div>
    </div>--}}
    </form>
</div>