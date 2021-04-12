<div class="card" id="{{$parent}}" wire:key="meta_{{$lang}}">
    <div class="card-body">
        <fieldset>
            <div class="form-row mb-2">
                <div class="col-md-12" wire:ignore>
                    <label class="required col-form-label" for="categories">{{ __('trx.categories') }}:</label>
                    <select class="categories-picker form-control"
                            multiple
                            wire:model="categories"
                            name="categories[]"
                            id="categories">
                        @foreach(\App\Models\Category::all() as $category)
                            <option
                                value="{{ $category->id }}"
                                @if (in_array($category->id, $categories->toArray()))
                                selected="selected"
                                @endif>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    <small class="footnote form-text text-muted font-italic">
                        {{ __('trx.categories_help') }}
                    </small>
                </div>
            </div>
            <div class="form-row mb-2">
                <div class="col-md-6">
                    <label class="col-form-label" for="prep_time">{{ __('trx.prep_time') }}:</label>
                    <input type="number"
                           class="form-control"
                           wire:model.defer="prep_time"
                           name="prep_time"
                           id="prep_time"
                           placeholder="{{ __('trx.in_minutes') }}">
                </div>
                <div class="col-md-6">
                    <label class="col-form-label" for="cook_time">{{ __('trx.cook_time') }}:</label>
                    <input type="number"
                           class="form-control"
                           wire:model.defer="cook_time"
                           name="cook_time"
                           id="cook_time"
                           placeholder="{{ __('trx.in_minutes') }}">
                </div>
            </div>
            @include('recipe.partial.create.servings', ['lang' => app()->getLocale(), 'parent' => 'w-servings'])
            @foreach($langs as $lang)
                @include('recipe.partial.create.servings', ['lang' => $lang, 'parent' => 'w-servings'])
            @endforeach
        </fieldset>
    </div>
</div>
