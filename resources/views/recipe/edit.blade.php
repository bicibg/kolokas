@extends('layouts.app')

@section('content')
    <div class="container kolokas-form">
        <div class="row justify-content-center kolokas-form">
            <div class="col-xs-12 col-md-8">
                <div class="header text-left">
                    <h2>Edit your recipe</h2>
                    <p>Make sure to have all relevant information as described under or next to each field. Mandatory
                        fields are
                        marked with *. Recipes that do not comply with Kolokas.com standards may be removed.</p>
                    <hr>
                </div>
            </div>
            <form method="POST" action="{{ route('recipe.update', $recipe) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="justify-content-center form-row">
                    <div class="col-xs-12 col-md-8">
                        <fieldset>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="title">Title:</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text"
                                           class="form-control-plaintext"
                                           readonly
                                           value="{{ $recipe->title }}"
                                           placeholder="Recipe Name"
                                           id="title">
                                    <small id="titleHelp" class="footnote form-text text-muted font-italic">
                                        Recipe's title cannot be edited
                                    </small>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="main_image">Main Photo:</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <img src="{{ $recipe->mainImage->url }}" alt="" class="img-thumbnail">
                                        </div>
                                    </div>
                                    <input type="file"
                                           class="bg-none border-0 form-control"
                                           name="main_image"
                                           id="main_image"/>
                                    <small id="titleHelp" class="footnote form-text text-muted font-italic">
                                        This is be the main image for your recipe.
                                    </small>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="images">Additional Photos:</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        @foreach($recipe->images as $image)
                                            @if ($image->main) @continue @endif
                                            <div class="col-md-2 text-center">
                                                <label class="image-checkbox">
                                                    <img class="img-thumbnail img-responsive" src="{{ $image->url }}">
                                                    <input name="existing_images[]"
                                                           value="{{ $image->id }}"
                                                           type="checkbox"
                                                           checked="checked">
                                                    <i class="fa fa-check hidden"></i>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="file" class="bg-none border-0 form-control" name="images[]" multiple
                                           id="images"/>
                                    <small id="titleHelp" class="footnote form-text text-muted font-italic">
                                        You can upload more than one (max 5). Your existing and new additional photos
                                        should not exceed 5. Deselect old photos if you want to replace them.
                                    </small>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="description">Short description:</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="description" id="description" cols="30" rows="10"
                                              class="form-control"
                                              placeholder="Recipe Description">{{ old('description') ?? $recipe->description }}</textarea>
                                    <small id="descriptionHelp" class="footnote form-text text-muted font-italic">Short
                                        description about this recipe</small>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="categories">Categories:</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="categories-picker form-control"
                                            multiple
                                            name="categories[]"
                                            id="categories">
                                        @foreach(\App\Models\Category::all() as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                @if (in_array($category->id, $recipe->categories->pluck('id')->toArray()))
                                                selected="selected"
                                                @endif
                                            >
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <small id="descriptionHelp" class="footnote form-text text-muted font-italic">You
                                        can select multiple categories.</small>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="prepTime">Prep Time:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="number"
                                           class="form-control"
                                           id="prepTime"
                                           name="prep_time"
                                           placeholder="in minutes"
                                           value="{{ old('prep_time') ?? $recipe->prep_time->minutes }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="col-form-label" for="cookTime">Cook Time:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="number"
                                           class="form-control"
                                           id="cookTime"
                                           name="cook_time"
                                           placeholder="in minutes"
                                           value="{{ old('cook_time') ?? $recipe->cook_time->minutes }}">
                                </div>
                            </div>

                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="servings">Servings:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text"
                                           class="form-control"
                                           id="servings"
                                           name="servings"
                                           placeholder="# of servings"
                                           value="{{ old('servings') ?? $recipe->servings }}">
                                </div>
                                <div class="col-md-2 form-control border-0">
                                    Ex: 3 scoops
                                </div>
                            </div>

                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="ingredients">Ingredients:</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="ingredients" id="ingredients" cols="30" rows="10"
                                              class="form-control"
                                              placeholder="Enter one ingredient per line.">{{ old('ingredients') ?? $recipe->getAttributes()['ingredients']}}</textarea>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="instructions">Instructions:</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="instructions" id="instructions" cols="30" rows="10"
                                              class="form-control"
                                              placeholder="Add all of the cooking instructions, one per line.">{{ old('instructions') ?? $recipe->getAttributes()['instructions'] }}</textarea>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="notes">Notes:</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="notes" id="notes" cols="30" rows="10" class="form-control"
                                              placeholder="Additional Notes">{{ old('notes') ?? $recipe->notes }}</textarea>
                                    <small id="ingredientsHelp" class="footnote form-text text-muted font-italic">
                                        Add any other notes like recipe source, cooking hints, etc. This section will
                                        show up under the cooking instructions.
                                    </small>
                                </div>
                            </div>
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
                                        {{ __('Update') }}
                                    </base-button>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection
