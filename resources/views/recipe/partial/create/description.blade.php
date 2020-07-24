<div class="card">
    <div class="card-header" id="heading_{{ $lang }}">
        <h2 class="mb-0">
            <button class="btn btn-link @if($lang === app()->getLocale()) collapsed @endif"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapse_{{$lang}}"
                    aria-expanded="@if($lang === app()->getLocale()) true @else false @endif"
                    aria-controls="collapse_{{$lang}}">
                {{ __('general.languages.' . $lang) }}
                @if($lang !== app()->getLocale())
                    ({{ __('recipe.create.can_be_auto_translated') }})
                @endif
            </button>
        </h2>
    </div>

    <div id="collapse_{{$lang}}"
         class="collapse @if($lang === app()->getLocale()) show @endif"
         aria-labelledby="heading_{{ $lang }}"
         data-parent="#{{$parent}}">
        <div class="card-body">
            <fieldset>
                <div class="form-row mb-2">
                    <div class="col-md-2">
                        <label class="col-form-label" for="title_{{ $lang }}">{{ __('recipe.title') }}:</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text"
                               class="form-control"
                               value="{{ old("lang.$lang.title") }}"
                               placeholder="Recipe Name"
                               name="lang[{{ $lang }}][title]"
                               id="title_{{ $lang }}">
                    </div>
                    <div class="col-md-2">
                        @if (app()->getLocale() !== $lang)
                            <a href="javascript:void(0)"
                               class="btn btn-link"
                               onclick="gtranslate('{{ app()->getLocale() }}', '{{ $lang }}', 'title')">
                                {!! __('general.translate', ['from' => __('general.languages.' . app()->getLocale()), 'to' => __('general.languages.' . $lang)]) !!}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="form-row mb-2">
                    <div class="col-md-2">
                        <label class="col-form-label" for="description_{{ $lang }}">{{ __('recipe.description') }}:</label>
                    </div>
                    <div class="col-md-8">
                        <textarea name="lang[{{ $lang }}][description]"
                                  id="description_{{ $lang }}"
                                  cols="30"
                                  rows="10"
                                  class="form-control"
                                  placeholder="Recipe Description">{{ old('description') }}</textarea>
                        <small id="descriptionHelp" class="footnote form-text text-muted font-italic">
                            {{ __('recipe.description_text') }}
                        </small>
                    </div>
                    <div class="col-md-2">
                        @if (app()->getLocale() !== $lang)
                            <a href="javascript:void(0)"
                               class="btn btn-link"
                               onclick="gtranslate('{{ app()->getLocale() }}', '{{ $lang }}', 'description')">
                                {!! __('general.translate', ['from' => __('general.languages.' . app()->getLocale()), 'to' => __('general.languages.' . $lang)]) !!}
                            </a>
                        @endif
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>
