<div class="card" wire:key="description_{{$lang}}">
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
                        <label class="col-form-label {{$lang === $locale ? 'required' : ''}}" for="servings_{{ $lang }}">{{ __('trx.servings') }}:</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text"
                               class="form-control"
                               wire:model="servings.{{ $lang }}"
                               name="servings.{{ $lang }}"
                               id="servings_{{ $lang }}"
                               placeholder="{{ __('trx.no_of_servings', [], $lang) }}">
                        <small id="descriptionHelp" class="footnote form-text text-muted font-italic">
                            {{ __('trx.servings_helper') }}
                        </small>
                    </div>
                    <div class="col-md-2">
                        @if (app()->getLocale() !== $lang)
                            <a href="javascript:void(0)"
                               class="btn btn-link"
                               onclick="gtranslate('{{ app()->getLocale() }}', '{{ $lang }}', 'servings')">
                                {!! __('trx.translate', ['from' => __('trx.languages.' . app()->getLocale()), 'to' => __('trx.languages.' . $lang)]) !!}
                            </a>
                        @endif
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>
