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
                        <label class="col-form-label" for="title">Title:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text"
                               class="form-control"
                               value="{{ old('title') }}"
                               placeholder="Recipe Name"
                               name="{{ $lang }}[title]"
                               id="title">
                        <small id="titleHelp" class="footnote form-text text-muted font-italic">
                            Keep it short and descriptive
                        </small>
                    </div>
                </div>
                <div class="form-row mb-2">
                    <div class="col-md-2">
                        <label class="col-form-label" for="description">Short description:</label>
                    </div>
                    <div class="col-md-10">
                        <textarea name="{{ $lang }}[description]"
                                  id="description"
                                  cols="30"
                                  rows="10"
                                  class="form-control"
                                  placeholder="Recipe Description">{{ old('description') }}</textarea>
                        <small id="descriptionHelp" class="footnote form-text text-muted font-italic">
                            Short description about this recipe
                        </small>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>
