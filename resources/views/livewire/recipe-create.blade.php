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
                <a class="nav-link mb-3 p-3 shadow {{ $tab == 'description' ? 'active' : '' }}"
                   wire:click="switchTab('description')"
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
                <a class="nav-link mb-3 p-3 shadow {{ $tab == 'media' ? 'active' : '' }}"
                   wire:click="switchTab('media')"
                   id="w-media-tab"
                   data-toggle="pill"
                   href="#w-media"
                   role="tab"
                   aria-controls="w-media"
                   aria-selected="false">
                    <i class="fa fa-photo mr-2"></i>
                    <span class="font-weight-bold small text-uppercase">{{ __('recipe.create.media') }}</span>
                    @if($tab2Check)
                        <i class="fa fa-check-circle-o float-right check"></i>
                    @else
                        <i class="fa fa-check-circle-o float-right"></i>
                    @endif
                </a>

                <a class="nav-link mb-3 p-3 shadow {{ $tab == 'meta' ? 'active' : '' }}"
                   wire:click="switchTab('meta')"
                   id="w-meta-tab"
                   data-toggle="pill"
                   href="#w-meta"
                   role="tab"
                   aria-controls="w-meta"
                   aria-selected="false">
                    <i class="fa fa-info mr-2"></i>
                    <span class="font-weight-bold small text-uppercase">{{ __('recipe.create.meta') }}</span>
                    @if($tab3Check)
                        <i class="fa fa-check-circle-o float-right check"></i>
                    @else
                        <i class="fa fa-check-circle-o float-right"></i>
                    @endif
                </a>

                <a class="nav-link mb-3 p-3 shadow {{ $tab == 'recipe' ? 'active' : '' }}"
                   wire:click="switchTab('recipe')"
                   id="w-recipe-tab"
                   data-toggle="pill"
                   href="#w-recipe"
                   role="tab"
                   aria-controls="w-recipe"
                   aria-selected="false">
                    <i class="fa fa-cutlery mr-2"></i>
                    <span class="font-weight-bold small text-uppercase">{{ __('recipe.create.recipe') }}</span>
                    @if($tab4Check)
                        <i class="fa fa-check-circle-o float-right check"></i>
                    @else
                        <i class="fa fa-check-circle-o float-right"></i>
                    @endif
                </a>
            </div>
        </div>

        <div class="col-md-9">
            <form method="POST" action="{{ route('recipe.store') }}" enctype="multipart/form-data" wire:submit.prevent="submit">
            @csrf
            <!-- Tabs content -->
                <div class="tab-content" id="v-pills-tabContent">
                    <div
                        class="tab-pane fade shadow rounded bg-white p-5 {{ $tab == 'description' ? 'active show' : '' }}"
                        id="w-description"
                        role="tabpanel"
                        aria-labelledby="w-description-tab">
                        @include('recipe.partial.create.description', ['lang' => app()->getLocale(), 'parent' => 'w-description'])
                        @foreach($langs as $lang)
                            @include('recipe.partial.create.description', ['lang' => $lang, 'parent' => 'w-description'])
                        @endforeach
                    </div>

                    <div class="tab-pane fade shadow rounded bg-white p-5 {{ $tab == 'media' ? 'active show' : '' }}"
                         id="w-media"
                         role="tabpanel"
                         aria-labelledby="w-media-tab">
                        <fieldset>
                            <div class="form-row mb-2">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="main_image">Main Photo:</label>
                                    <input type="file" class="bg-none border-0 form-control" name="main_image"
                                           id="main_image"/>
                                    <small id="imageHelp" class="footnote form-text text-muted font-italic">
                                        This will be the main image for your recipe
                                    </small>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col-md-12">
                                    <label class="col-form-label" for="images">Additional Photos:</label>
                                    <input type="file" class="bg-none border-0 form-control" wire:model="images"
                                           multiple
                                           id="images"/>
                                    <small id="imagesHelp" class="footnote form-text text-muted font-italic">
                                        You can upload more than one (max 5)
                                    </small>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="tab-pane fade shadow rounded bg-white p-5 {{ $tab == 'meta' ? 'active show' : '' }}"
                         id="w-meta"
                         role="tabpanel"
                         aria-labelledby="w-meta-tab">
                        @include('recipe.partial.create.meta', ['lang' => app()->getLocale(), 'parent' => 'w-meta'])
                    </div>

                    <div class="tab-pane fade shadow rounded bg-white p-5 {{ $tab == 'recipe' ? 'active show' : '' }}"
                         id="w-recipe"
                         role="tabpanel"
                         aria-labelledby="w-recipe-tab">
                        @include('recipe.partial.create.recipe', ['lang' => app()->getLocale(), 'parent' => 'w-recipe'])
                        @foreach($langs as $lang)
                            @include('recipe.partial.create.recipe', ['lang' => $lang, 'parent' => 'w-recipe'])
                        @endforeach
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
                                               @if($agreement) checked="checked"
                                               @endif
                                               wire:model="agreement">
                                        <label class="form-check-label" for="agreement"> &nbsp;
                                            I agree to the above and confirm this recipe is original to me.
                                        </label>
                                    </p>
                                </div>
                                <button
                                    class="btn btn-lg {{ $canSubmit ? 'btn-primary' : 'btn-dark' }} btn-base"
                                    type="submit" {{ $canSubmit ? '' : 'disabled' }}>
                                    {{ __('Submit for review') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
