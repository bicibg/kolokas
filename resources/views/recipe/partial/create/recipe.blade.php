<div class="card" wire:key="recipe_{{$lang}}">
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
                        <label class="required col-form-label" for="ingredients_{{ $lang }}">{{ __('trx.ingredients') }}:</label>
                    </div>
                    <div class="col-md-8">
                        <textarea id="ingredients_{{ $lang }}"
                                  cols="30"
                                  rows="10"
                                  class="form-control"
                                  wire:model="ingredients.{{ $lang }}"
                                  name="ingredients.{{ $lang }}"></textarea>
                        <small id="ingredientsHelp" class="footnote form-text text-muted font-italic">
                            {{__('trx.one_ingredient_per_line') }}
                        </small>
                    </div>
                    <div class="col-md-2">
                        @if (app()->getLocale() !== $lang)
                            <a href="javascript:void(0)"
                               class="btn btn-link"
                               onclick="gtranslate('{{ app()->getLocale() }}', '{{ $lang }}', 'ingredients')">
                                {!! __('trx.translate', ['from' => __('trx.languages.' . app()->getLocale()), 'to' => __('trx.languages.' . $lang)]) !!}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="form-row mb-2">
                    <div class="col-md-2">
                        <label class="required col-form-label" for="instructions_{{ $lang }}">{{ __('trx.instructions') }}:</label>
                    </div>
                    <div class="col-md-8">
                        <textarea id="instructions_{{ $lang }}"
                                  cols="30"
                                  rows="10"
                                  class="form-control"
                                  wire:model="instructions.{{ $lang }}"
                                  name="instructions.{{ $lang }}"></textarea>
                        <small id="instructionsHelp" class="footnote form-text text-muted font-italic">
                            {{__('trx.add_all_cooking_instructions') }}
                        </small>
                    </div>
                    <div class="col-md-2">
                        @if (app()->getLocale() !== $lang)
                            <a href="javascript:void(0)"
                               class="btn btn-link"
                               onclick="gtranslate('{{ app()->getLocale() }}', '{{ $lang }}', 'instructions')">
                                {!! __('trx.translate', ['from' => __('trx.languages.' . app()->getLocale()), 'to' => __('trx.languages.' . $lang)]) !!}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="form-row mb-2">
                    <div class="col-md-2">
                        <label class="col-form-label" for="notes_{{ $lang }}">{{ __('trx.notes') }}:</label>
                    </div>
                    <div class="col-md-8">
                        <textarea id="notes_{{ $lang }}"
                                  cols="30"
                                  rows="10"
                                  class="form-control"
                                  wire:model="notes.{{ $lang }}"
                                  name="notes.{{ $lang }}"></textarea>
                        <small id="notesHelp" class="footnote form-text text-muted font-italic">
                            {{__('trx.add_notes') }}
                        </small>
                    </div>
                    <div class="col-md-2">
                        @if (app()->getLocale() !== $lang)
                            <a href="javascript:void(0)"
                               class="btn btn-link"
                               onclick="gtranslate('{{ app()->getLocale() }}', '{{ $lang }}', 'notes')">
                                {!! __('trx.translate', ['from' => __('trx.languages.' . app()->getLocale()), 'to' => __('trx.languages.' . $lang)]) !!}
                            </a>
                        @endif
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>
