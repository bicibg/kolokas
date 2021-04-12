<div class="card" id="{{$parent}}" wire:key="description_{{$lang}}">
    <div class="card-header" id="heading_{{ $lang }}">
        <h2 class="mb-0">
            <button class="btn btn-link @if($lang === $langTab) collapsed @endif"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapse_{{$lang}}"
                    aria-expanded="@if($lang === $langTab) true @else false @endif"
                    aria-controls="collapse_{{$lang}}"
                    wire:click="switchLangTab('{{$lang}}')">
                {{ __('trx.languages.' . $lang) }}
                @if($lang !== app()->getLocale())
                    ({{ __('trx.can_be_auto_translated') }})
                @endif
            </button>
        </h2>
    </div>

    <div id="collapse_{{$lang}}"
         class="collapse @if($lang === $langTab) show @endif"
         aria-labelledby="heading_{{ $lang }}"
         data-parent="#{{$parent}}">
        <div class="card-body">
            <fieldset>
                <div class="form-row mb-2">
                    <div class="col-md-2">
                        <label class="col-form-label {{$lang === $locale ? 'required' : ''}}"
                               for="title_{{ $lang }}">{{ __('trx.recipe_title') }}:</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text"
                               class="form-control"
                               wire:model.defer="title.{{ $lang }}"
                               name="title.{{ $lang }}"
                               id="title_{{ $lang }}">
                    </div>
                    <div class="col-md-2">
                        @if (app()->getLocale() !== $lang)
                            <a href="javascript:void(0)"
                               class="btn btn-link translate-btn"
                               onclick="gtranslate('{{ app()->getLocale() }}', '{{ $lang }}', 'title', this)">
                                {!! __('trx.translate', ['from' => __('trx.languages.' . app()->getLocale()), 'to' => __('trx.languages.' . $lang)]) !!}
                                <div class="spinner spinner-border text-primary hidden" role="status">
                                    <span class="sr-only">{{__('trx.translating')}}</span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="form-row mb-2">
                    <div class="col-md-2">
                        <label class="col-form-label"
                               for="description_{{ $lang }}">{{ __('trx.recipe_description') }}:</label>
                    </div>
                    <div class="col-md-8">
                        <textarea id="description_{{ $lang }}"
                                  cols="30"
                                  rows="10"
                                  class="form-control"
                                  wire:model="description.{{ $lang }}"
                                  name="description.{{ $lang }}"></textarea>
                        <small id="descriptionHelp" class="footnote form-text text-muted font-italic">
                            {{ __('trx.recipe_description_helper') }}
                        </small>
                    </div>
                    <div class="col-md-2">
                        @if (app()->getLocale() !== $lang)
                            <a href="javascript:void(0)"
                               class="btn btn-link translate-btn"
                               onclick="gtranslate('{{ app()->getLocale() }}', '{{ $lang }}', 'description', this)">
                                {!! __('trx.translate', ['from' => __('trx.languages.' . app()->getLocale()), 'to' => __('trx.languages.' . $lang)]) !!}
                                <div class="spinner spinner-border text-primary hidden" role="status">
                                    <span class="sr-only">{{__('trx.translating')}}</span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>
