<div class="card">
    <div class="card-header" id="heading_{{ $locale }}">
        <h2 class="mb-0">
            <button class="btn btn-link @if($locale === app()->getLocale()) collapsed @endif"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapse_{{$locale}}"
                    aria-expanded="@if($locale === app()->getLocale()) true @else false @endif"
                    aria-controls="collapse_{{$locale}}">
                {{ __('general.languages.' . $locale) }}
                @if($locale !== app()->getLocale())
                    ({{ __('recipe.create.can_be_auto_translated') }})
                @endif
            </button>
        </h2>
    </div>

    <div id="collapse_{{$locale}}"
         class="collapse @if($locale === app()->getLocale()) show @endif"
         aria-labelledby="heading_{{ $locale }}"
         data-parent="#{{$parent}}">
        <div class="card-body">
            <fieldset>
                <div class="form-row mb-2">
                    <div class="col-md-2">
                        <label class="col-form-label" for="title_{{ $locale }}">{{ __('recipe.title') }}:</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text"
                               class="form-control"
                               value="{{ old("lang.$locale.title") }}"
                               name="lang[{{ $locale }}][title]"
                               wire:model="title.{{ $locale }}"
                               id="title_{{ $locale }}">
                    </div>
                    <div class="col-md-2">
                        @if (app()->getLocale() !== $locale)
                            <a href="javascript:void(0)"
                               class="btn btn-link"
                               onclick="gtranslate('{{ app()->getLocale() }}', '{{ $locale }}', 'title')">
                                {!! __('general.translate', ['from' => __('general.languages.' . app()->getLocale()), 'to' => __('general.languages.' . $locale)]) !!}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="form-row mb-2">
                    <div class="col-md-2">
                        <label class="col-form-label" for="description_{{ $locale }}">{{ __('recipe.create.description') }}:</label>
                    </div>
                    <div class="col-md-8">
                        <textarea name="lang[{{ $locale }}][description]"
                                  id="description_{{ $locale }}"
                                  cols="30"
                                  rows="10"
                                  class="form-control"
                                  wire:model="description.{{ $locale }}">{{ old('description') }}</textarea>
                        <small id="descriptionHelp" class="footnote form-text text-muted font-italic">
                            {{ __('recipe.create.description_text') }}
                        </small>
                    </div>
                    <div class="col-md-2">
                        @if (app()->getLocale() !== $locale)
                            <a href="javascript:void(0)"
                               class="btn btn-link"
                               onclick="gtranslate('{{ app()->getLocale() }}', '{{ $locale }}', 'description')">
                                {!! __('general.translate', ['from' => __('general.languages.' . app()->getLocale()), 'to' => __('general.languages.' . $locale)]) !!}
                            </a>
                        @endif
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>
