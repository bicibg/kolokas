<div class="card">
    <div class="card-body">
        <fieldset>
            <div class="form-row mb-2">
                <div class="col-md-12" wire:ignore>
                    <label class="required col-form-label" for="categories">Categories:</label>
                    <select class="categories-picker form-control"
                            multiple
                            wire:model="categories"
                            id="categories">
                        @foreach(\App\Models\Category::all() as $category)
                            <option
                                value="{{ $category->id }}"
                                @if (in_array($category->id, old('categories', [])))
                                selected="selected"
                                @endif
                            >
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    <small id="descriptionHelp" class="footnote form-text text-muted font-italic">
                        You can select multiple categories.
                    </small>
                </div>
            </div>
            <div class="form-row mb-2">
                <div class="col-md-6">
                    <label class="required col-form-label" for="prep_time">Prep Time:</label>
                    <input type="number"
                           class="form-control"
                           value="{{ old("prep_time") }}"
                           name="prep_time"
                           wire:model="prep_time"
                           id="prep_time"
                           placeholder="{{ __('recipe.in_minutes') }}">
                </div>
                <div class="col-md-6">
                    <label class="required col-form-label" for="cook_time">Cook Time:</label>
                    <input type="number"
                           class="form-control"
                           value="{{ old("cook_time") }}"
                           name="cook_time"
                           wire:model="cook_time"
                           id="cook_time"
                           placeholder="{{ __('recipe.in_minutes') }}">
                </div>
            </div>
            <div class="form-row mb-2">
                <div class="col-md-6">
                    <label class="required col-form-label" for="servings">Servings:</label>
                    <input type="text"
                           class="form-control"
                           value="{{ old("lang.$lang.servings") }}"
                           name="lang[{{ $lang }}][servings]"
                           wire:model="servings.{{ $lang }}"
                           id="servings_{{ $lang }}"
                           placeholder="{{ __('recipe.no_of_servings') }}">
                    <small id="descriptionHelp" class="footnote form-text text-muted font-italic">
                    {{ 'recipe.servings_note' }} <!-- Ex. 3 Scoops -->
                    </small>
                </div>
            </div>
        </fieldset>
    </div>
</div>
