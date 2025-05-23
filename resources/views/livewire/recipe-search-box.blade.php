<div class="search my-3">
    <form method="get" class="search-form" action="{{ $action }}">
        <div class="basic-search">
            <div class="input-field position-relative">
                <div class="row flex align-items-center bg-white py-2 m-0">
                    <div class="col-md-4">
                        <div class="icon-wrap">
                            {{--                <i class="fa fa-search"></i>--}}
                            <svg version="1.1"
                                 xmlns="http://www.w3.org/2000/svg"
                                 width="20"
                                 height="20"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M18.869 19.162l-5.943-6.484c1.339-1.401 2.075-3.233 2.075-5.178 0-2.003-0.78-3.887-2.197-5.303s-3.3-2.197-5.303-2.197-3.887 0.78-5.303 2.197-2.197 3.3-2.197 5.303 0.78 3.887 2.197 5.303 3.3 2.197 5.303 2.197c1.726 0 3.362-0.579 4.688-1.645l5.943 6.483c0.099 0.108 0.233 0.162 0.369 0.162 0.121 0 0.242-0.043 0.338-0.131 0.204-0.187 0.217-0.503 0.031-0.706zM1 7.5c0-3.584 2.916-6.5 6.5-6.5s6.5 2.916 6.5 6.5-2.916 6.5-6.5 6.5-6.5-2.916-6.5-6.5z"></path>
                            </svg>
                        </div>
                        <input id="search"
                               type="text"
                               name="s"
                               value="{{ request()->get('s') }}"
                               placeholder="{{ __('trx.search_term') }}...">
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" wire:ignore id="categories_container">
                            <label for="category">{{ __('trx.categories') }}</label>
                            <select name="c"
                                    data-container="#categories_container"
                                    id="category"
                                    class="selectpicker form-control show-tick"
                                    data-live-search="true">
                                <option value
                                        class="font-weight-bold"
                                        @if(empty(request()->get('s'))) selected="selected" @endif>
                                    {{ __('trx.all_categories') }}
                                </option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            @if(request()->get('c') == $category->id) selected="selected" @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" wire:ignore id="author_container">
                            <label for="author">{{ trans_choice('trx.author_capital',1) }}</label>
                            <select name="a"
                                    data-container="#author_container"
                                    id="author"
                                    class="selectpicker form-control show-tick"
                                    data-live-search="true">
                                <option value
                                        class="font-weight-bold"
                                        @if(empty(request()->get('a'))) selected="selected" @endif>
                                    {{ __('trx.all_authors') }}
                                </option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->slug }}"
                                            @if(request()->get('a') == $author->slug) selected="selected" @endif>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if($extended)
                        <div class="col-md-2"></div>
                    @else
                        <div class="col-md-2 text-center">
                            <div class="result-count mr-3">
                                <span>{{ $resultCount }} </span>{{ trans_choice('trx.recipe', $resultCount) }}
                            </div>
                            <base-button :role="'submit'">
                                {{ __('trx.search') }}
                            </base-button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if($extended)
            <div class="advance-search">
                <div class="row flex align-items-center bg-white py-2 m-0">
                    <div class="col-md-5 justify-content-center">
                        <div class="form-group form-inline w-75 mr-auto ml-auto mb-0">
                            <label for="max_prep_time">{{ __('trx.max_prep_time') }}:&nbsp;
                                <input id="max_prep_time"
                                       type="text"
                                       readonly
                                       class="form-control-plaintext max-time-input"
                                       value="{{ trans_choice('trx.minutes', $maxPrepTime, ['minute' => $maxPrepTime]) }}">
                            </label>
                        </div>
                        <div class="slidecontainer w-75 mr-auto ml-auto">
                            <input id="prep_time"
                                   type="range"
                                   wire:model="maxPrepTime"
                                   min="{{ $cookTimes['minPrep'] }}"
                                   max="{{ $cookTimes['maxPrep'] }}"
                                   value="{{ $maxPrepTime }}"
                                   step="5"
                                   name="mp"
                                   class="slider">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-inline w-75 mr-auto ml-auto mb-0">
                            <label for="max_cook_time">{{ __('trx.max_cook_time') }}:&nbsp;
                                <input id="max_cook_time"
                                       type="text"
                                       readonly
                                       class="form-control-plaintext max-time-input"
                                       value="{{ trans_choice('trx.minutes', $maxCookTime, ['minute' => $maxCookTime]) }}">
                            </label>
                        </div>
                        <div class="slidecontainer w-75 mr-auto ml-auto">
                            <input id="cook_time"
                                   type="range"
                                   wire:model="maxCookTime"
                                   min="{{ $cookTimes['minCook'] }}"
                                   max="{{ $cookTimes['maxCook'] }}"
                                   value="{{ $maxCookTime }}"
                                   step="5"
                                   name="mc"
                                   class="slider">
                        </div>
                    </div>
                    @if($extended)
                        <div class="col-md-2 text-center pt-4">
                            <div class="result-count mr-3">
                                <span>{{ $resultCount }} </span>{{ trans_choice('trx.recipe', $resultCount) }}
                            </div>
                            <base-button :role="'submit'">
                                {{ __('trx.search') }}
                            </base-button>
                        </div>
                    @else
                        <div class="col-md-2"></div>
                    @endif
                </div>
            </div>
        @endif
    </form>
</div>
