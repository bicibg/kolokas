@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="heading">
            <h2>Create your recipe</h2>
        </div>
        @if(session()->has('message'))
            <div class="alert alert-success">{{session()->get('message')}}</div>
        @endif
        @if(count($errors)>0)

            <ul>
                @foreach($errors->all() as $error)
                    <li class="alert alert-danger">{{$error}}</li>
                @endforeach
            </ul>
        @endif
        <form method="POST" action="{{ route('recipe.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="justify-content-center form-row">
                <div class="col-md-8">
                    <fieldset class="recipe-details">
                        <div class="form-row mb-2">
                            <div class="col-md-2">
                                <label class="col-form-label" for="title">Title:</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" value="{{ old('title') }}"
                                       placeholder="Recipe Name" name="title" id="title">
                                <small id="titleHelp" class="footnote form-text text-muted font-italic">Keep it
                                    short and
                                    descriptive</small>
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col-md-2">
                                <label class="col-form-label" for="images">Photos:</label>
                            </div>
                            <div class="col-md-10">
                                <input type="file" class="bg-none border-0 form-control" name="images[]" multiple placeholder="Photos" id="images"/>
                                <small id="titleHelp" class="footnote form-text text-muted font-italic">
                                    You can upload more than one
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
                                              placeholder="Recipe Description">{{ old('description') }}</textarea>
                                <small id="descriptionHelp" class="footnote form-text text-muted font-italic">Short
                                    description about this recipe</small>
                            </div>
                        </div>

                        <div class="form-row mb-2">
                            <div class="col-md-2">
                                <label class="col-form-label" for="prepTime">Prep Time:</label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control" id="prepTime" name="prep_time"
                                       placeholder="in minutes" value="{{ old('prep_time') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label" for="cookTime">Cook Time:</label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control" id="cookTime" name="cook_time"
                                       placeholder="in minutes" value="{{ old('cook_time') }}">
                            </div>
                        </div>

                        <div class="form-row mb-2">
                            <div class="col-md-2">
                                <label class="col-form-label" for="servings">Servings:</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="servings" name="servings"
                                       placeholder="# of servings" value="{{ old('servings') }}">
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
                                              placeholder="Enter one ingredient per line.">{{ old('ingredients') }}
                                    </textarea>
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col-md-2">
                                <label class="col-form-label" for="instructions">Instructions:</label>
                            </div>
                            <div class="col-md-10">
                                    <textarea name="instructions" id="instructions" cols="30" rows="10"
                                              class="form-control"
                                              placeholder="Add all of the cooking instructions, one per line.">{{ old('instructions') }}
                                    </textarea>
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
                        <div class="form-row mb-2 mt-5">
                            <div class="offset-md-2 col-md-10 border-top">
                                <div class="muted">
                                    <p><span class="rd_tg_bold">NOTE:</span> Photos may be used in print publications or
                                        on
                                        the
                                        website. Please submit a high resolution jpg image at 300dpi. Uploaded files are
                                        limited to
                                        a max file size of 15 mb.</p>

                                    <p>By submitting material for publication, you grant {{ env('APP_CLEAN_URL') }}
                                        unrestricted use of the
                                        material,
                                        including your name, hometown and state. We reserve the right to modify,
                                        reproduce
                                        and
                                        distribute the material in any medium and in any manner. We may contact you via
                                        phone, email
                                        or mail regarding your submission.</p>
                                    <p>
                                        <input type="checkbox" class="form-check-input" id="agreement" name="agreement">
                                        <label class="form-check-label" for="agreement"> &nbsp; I agree to the above and
                                            confirm this recipe is original to me.</label>
                                    </p>
                                </div>
                                <button class="btn btn-success" type="submit">Submit for review</button>
                            </div>
                        </div>
                    </fieldset>

                </div>
            </div>

        </form>
    </div>
@endsection
