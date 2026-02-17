<div class="container-fluid kolokas-form mt-5">
    @if (!empty($this->getErrorBag()->messages()))
        <ul class="validation-errors">
            @foreach($this->getErrorBag()->messages() as $error)
                <li class="alert alert-danger">{{$error[0]}}</li>
            @endforeach
        </ul>
    @endif
    <div class="row justify-content-center kolokas-form">
        <div class="col-sm-12">
            <div class="header text-center">
                <h2>{{ __('trx.edit_page_title') }}</h2>
                <p>{{ __('trx.create_page_info') }}</p>
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
                   data-bs-toggle="pill"
                   href="#w-description"
                   role="tab"
                   aria-controls="w-description"
                   aria-selected="true">
                    <i class="fas fa-pen me-2"></i>
                    <span class="fw-bold small text-uppercase">{{ __('trx.recipe_description') }}</span>
                    @if($tab1Check)
                        <i class="far fa-check-circle float-end check"></i>
                    @else
                        <i class="far fa-check-circle float-end"></i>
                    @endif
                </a>
                <a class="nav-link mb-3 p-3 shadow {{ $tab == 'media' ? 'active' : '' }}"
                   wire:click="switchTab('media')"
                   id="w-media-tab"
                   data-bs-toggle="pill"
                   href="#w-media"
                   role="tab"
                   aria-controls="w-media"
                   aria-selected="false">
                    <i class="fas fa-image me-2"></i>
                    <span class="fw-bold small text-uppercase">{{ __('trx.media') }}</span>
                    @if($tab2Check)
                        <i class="far fa-check-circle float-end check"></i>
                    @else
                        <i class="far fa-check-circle float-end"></i>
                    @endif
                </a>

                <a class="nav-link mb-3 p-3 shadow {{ $tab == 'meta' ? 'active' : '' }}"
                   wire:click="switchTab('meta')"
                   id="w-meta-tab"
                   data-bs-toggle="pill"
                   href="#w-meta"
                   role="tab"
                   aria-controls="w-meta"
                   aria-selected="false">
                    <i class="fas fa-info me-2"></i>
                    <span class="fw-bold small text-uppercase">{{ __('trx.meta') }}</span>
                    @if($tab3Check)
                        <i class="far fa-check-circle float-end check"></i>
                    @else
                        <i class="far fa-check-circle float-end"></i>
                    @endif
                </a>

                <a class="nav-link mb-3 p-3 shadow {{ $tab == 'recipe' ? 'active' : '' }}"
                   wire:click="switchTab('recipe')"
                   id="w-recipe-tab"
                   data-bs-toggle="pill"
                   href="#w-recipe"
                   role="tab"
                   aria-controls="w-recipe"
                   aria-selected="false">
                    <i class="fas fa-utensils me-2"></i>
                    <span class="fw-bold small text-uppercase">{{ __('trx.recipe') }}</span>
                    @if($tab4Check)
                        <i class="far fa-check-circle float-end check"></i>
                    @else
                        <i class="far fa-check-circle float-end"></i>
                    @endif
                </a>
            </div>
        </div>
        <div class="col-md-9">
            <form method="POST" enctype="multipart/form-data" wire:submit.prevent="{{ $canSubmit ? 'submit' : '' }}">
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
                        @include('recipe.partial.create.media', ['lang' => app()->getLocale(), 'parent' => 'w-media'])
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
                <div class="row g-3">
                    <div class="col-md-12 justify-content-end">
                        <div class="row g-3 mb-2 mt-5">
                            <div class="offset-md-2 col-md-10 border-top">
                                <div class="muted">
                                    <p>{{ __('trx.agreement') }}</p>
                                    <p>
                                        <input type="checkbox"
                                               class="form-check-input"
                                               id="agreement"
                                               @if($agreement) checked="checked"
                                               @endif
                                               wire:model.live="agreement">
                                        <label class="form-check-label" for="agreement"> &nbsp;
                                            {{ __('trx.agreement_agree') }}
                                        </label>
                                    </p>
                                </div>
                                <button
                                    class="btn btn-lg {{ $canSubmit ? 'btn-primary' : 'btn-dark' }} btn-base"
                                    type="submit" {{ $canSubmit ? '' : 'disabled' }}>
                                    {{ __('trx.submit_for_review') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
