<div class="row justify-content-center w-100">
    <div class="col-md-12">
        <form method="get" class="search-form" action="{{ $action ?? route('recipe.index') }}">
            <div class="search-box inner-form">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="form-group input-field first-wrap">
                            <select name="c" id="recipe-type" class="form-control">
                                <option value="0" @if(empty(request()->get('s'))) selected="selected" @endif>
                                    – {{ __('general.choose_category') }} –
                                </option>
                                @foreach($categories as $category)
                                    <option class="level-0" value="{{ $category->id }}"
                                            @if(request()->get('c') == $category->id) selected="selected" @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-3 col-xs-6">
                        <div class="form-group input-field second-wrap">
                            <div class="input-group mb-3 has-clear">
                                <input type="text" class="form-control" placeholder="{{ __('general.search_by_keyword') }}"
                                       value="{{ request()->get('s') }}" name="s" aria-describedby="clear">
                                <div class="input-group-append form-control-clear form-control-feedback hidden">
                                    <span class="input-group-text clear" id="clear">{{ __('general.clear') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="action-buttons w-100 text-center">
                            <base-button role="submit">
                                <i class="fa fa-search"></i>
                                {{ __('general.search') }}
                            </base-button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
