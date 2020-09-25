<div class="container-fluid kolokas-form mt-5">
    <div class="row justify-content-center kolokas-form">
        <div class="col-sm-12">
            <div class="header text-center">
                <h2>{{ __('recipe.create.title') }}</h2>
                <p>{{ __('recipe.create.recipe_create_info') }}</p>
                <hr>
            </div>
        </div>
        <div class="col-md-3">
            <!-- Tabs nav -->
            <div class="nav flex-column nav-pills nav-pills-custom"
                 id="v-pills-tab"
                 role="tablist"
                 aria-orientation="vertical">
                <a class="nav-link mb-3 p-3 shadow active"
                   id="w-description-tab"
                   data-toggle="pill"
                   href="#w-description"
                   role="tab"
                   aria-controls="w-description"
                   aria-selected="true">
                    <i class="fa fa-pen mr-2"></i>
                    <span class="font-weight-bold small text-uppercase">{{ __('recipe.create.description') }}</span>
                    @if($tab1Check)
                        <i class="fa fa-check-circle-o float-right check"></i>
                    @else
                        <i class="fa fa-check-circle-o float-right"></i>
                    @endif
                </a>
                <a class="nav-link mb-3 p-3 shadow"
                   id="w-media-tab"
                   data-toggle="pill"
                   href="#w-media"
                   role="tab"
                   aria-controls="w-media"
                   aria-selected="false">
                    <i class="fa fa-photo mr-2"></i>
                    <span class="font-weight-bold small text-uppercase">{{ __('recipe.create.media') }}</span>
                    <i class="fa fa-check-circle-o float-right"></i>
                </a>

                <a class="nav-link mb-3 p-3 shadow"
                   id="w-meta-information-tab"
                   data-toggle="pill"
                   href="#w-meta-information"
                   role="tab"
                   aria-controls="w-meta-information"
                   aria-selected="false">
                    <i class="fa fa-info mr-2"></i>
                    <span class="font-weight-bold small text-uppercase">{{ __('recipe.create.meta') }}</span>
                    <i class="fa fa-check-circle-o float-right"></i>
                </a>

                <a class="nav-link mb-3 p-3 shadow"
                   id="w-recipe-tab"
                   data-toggle="pill"
                   href="#w-recipe"
                   role="tab"
                   aria-controls="w-recipe"
                   aria-selected="false">
                    <i class="fa fa-cutlery mr-2"></i>
                    <span class="font-weight-bold small text-uppercase">{{ __('recipe.create.recipe') }}</span>
                    <i class="fa fa-check-circle-o float-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-9">
            <form method="POST" action="{{ route('recipe.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Tabs content -->
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade shadow rounded bg-white show active p-5"
                         id="w-description"
                         role="tabpanel"
                         aria-labelledby="w-description-tab">
                        @include('recipe.partial.create.description', ['lang' => app()->getLocale(), 'parent' => 'w-description'])
                        @foreach($langs as $lang)
                            @include('recipe.partial.create.description', ['lang' => $lang, 'parent' => 'w-description'])
                        @endforeach
                    </div>

                    <div class="tab-pane fade shadow rounded bg-white p-5"
                         id="w-media"
                         role="tabpanel"
                         aria-labelledby="w-media-tab">
                        <fieldset>
                            <div class="form-row mb-2">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="main_image">Main Photo:</label>
                                    <input type="file" class="bg-none border-0 form-control" name="main_image"
                                           id="main_image"/>
                                    <small id="titleHelp" class="footnote form-text text-muted font-italic">
                                        This will be the main image for your recipe
                                    </small>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="images">Additional Photos:</label>
                                    <input type="file" class="bg-none border-0 form-control" name="images[]" multiple
                                           id="images"/>
                                    <small id="titleHelp" class="footnote form-text text-muted font-italic">
                                        You can upload more than one (max 5)
                                    </small>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="tab-pane fade shadow rounded bg-white p-5"
                         id="w-meta-information"
                         role="tabpanel"
                         aria-labelledby="w-meta-information-tab">
                        <div class="form-row mb-2">
                            <div class="col-md-12">
                                <label class="col-form-label" for="categories">Categories:</label>
                                <select class="categories-picker form-control"
                                        multiple
                                        name="categories[]"
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
                                <label class="col-form-label" for="prepTime">Prep Time:</label>
                                <input type="number"
                                       class="form-control"
                                       id="prepTime"
                                       name="prep_time"
                                       placeholder="in minutes"
                                       value="{{ old('prep_time') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="cookTime">Cook Time:</label>
                                <input type="number"
                                       class="form-control"
                                       id="cookTime"
                                       name="cook_time"
                                       placeholder="in minutes"
                                       value="{{ old('cook_time') }}">
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col-md-6">
                                <label class="required col-form-label" for="servings">Servings:</label>
                                <input type="text"
                                       class="form-control"
                                       id="servings"
                                       name="servings"
                                       placeholder="# of servings"
                                       value="{{ old('servings') }}">
                                <small id="descriptionHelp" class="footnote form-text text-muted font-italic">
                                    Ex: 3 scoops
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade shadow rounded bg-white p-5"
                         id="w-recipe"
                         role="tabpanel"
                         aria-labelledby="w-recipe-tab">
                        <fieldset>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="ingredients">Ingredients:</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="ingredients" id="ingredients" cols="30" rows="10"
                                              class="form-control"
                                              placeholder="Enter one ingredient per line.">{{ old('ingredients') }}</textarea>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="instructions">Instructions:</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="instructions" id="instructions" cols="30" rows="10"
                                              class="form-control"
                                              placeholder="Add all of the cooking instructions, one per line.">{{ old('instructions') }}</textarea>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="notes">Notes:</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="notes" id="notes" cols="30" rows="10" class="form-control"
                                              placeholder="Additional Notes">{{ old('notes') }}</textarea>
                                    <small id="ingredientsHelp" class="footnote form-text text-muted font-italic">
                                        Add any other notes like recipe source, cooking hints, etc. This section will
                                        show up under the cooking instructions.
                                    </small>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 justify-content-end">
                        <div class="form-row mb-2 mt-5">
                            <div class="offset-md-2 col-md-10 border-top">
                                <div class="muted">
                                    <p>By submitting material for publication, you grant {{ env('APP_CLEAN_URL') }}
                                        unrestricted use of the material, including your profile information.
                                        We reserve the right to modify, reproduce and distribute the material in any
                                        medium and in any manner. We may contact you via phone, email or mail
                                        regarding your submission.
                                    </p>
                                    <p>
                                        <input type="checkbox"
                                               class="form-check-input"
                                               id="agreement"
                                               @if(old('agreement')) checked="checked"
                                               @endif
                                               name="agreement">
                                        <label class="form-check-label" for="agreement"> &nbsp;
                                            I agree to the above and confirm this recipe is original to me.
                                        </label>
                                    </p>
                                </div>
                                <base-button :role="'submit'">
                                    {{ __('Submit for review') }}
                                </base-button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
