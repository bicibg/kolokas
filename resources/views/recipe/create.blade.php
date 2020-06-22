@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="justify-content-center">
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
            <form method="POST" action="{{ route('recipe.store') }}">
                @csrf
                <div class="justify-content-center form-row">
                    <div class="col-md-6">
                        <h4>Details</h4>
                        <fieldset class="recipe-details">
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="title">Title:</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ old('title') }}"
                                           placeholder="Recipe Name" name="title" id="title">
                                    <small id="titleHelp" class="form-text text-muted font-italic">Keep it short and
                                        descriptive</small>
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
                                    <small id="descriptionHelp" class="form-text text-muted font-italic">Short
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
                                              placeholder="Ingredients">{{ old('ingredients') }}</textarea>
                                    <small id="ingredientsHelp" class="form-text text-muted font-italic">Enter one
                                        ingredient per line. Use a double dash to start new section titles. (ex.
                                        --Section Title).</small>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="instructions">Instructions:</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="instructions" id="instructions" cols="30" rows="10"
                                              class="form-control"
                                              placeholder="Instructions">{{ old('instructions') }}</textarea>
                                    <small id="instructionsHelp" class="form-text text-muted font-italic">Add all of the
                                        cooking steps, one per line. You can use a double dash for section
                                        titles.</small>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label class="col-form-label" for="notes">Notes:</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="notes" id="notes" cols="30" rows="10" class="form-control"
                                              placeholder="Recipe Notes">{{ old('notes') }}</textarea>
                                    <small id="ingredientsHelp" class="form-text text-muted font-italic">Add any other
                                        notes like recipe source, cooking hints, etc. This section will show up under
                                        the cooking directions.</small>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                </div>

                <div class="form-row">&nbsp;</div>


                <div class="form-row">
                    <div class="offset-md-3 col-md-6">
                        <button class="btn btn-success form-control" type="submit">Submit for review</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
