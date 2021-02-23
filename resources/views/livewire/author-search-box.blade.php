<div class="search my-3">
    <form method="get" class="search-form" action="{{ $action }}">
        <div class="basic-search">
            <div class="input-field position-relative">
                <div class="row flex align-items-center bg-white py-2 m-0">
                    <div class="col-md-10">
                        <div class="icon-wrap">
                            <svg version="1.1"
                                 xmlns="http://www.w3.org/2000/svg"
                                 width="20"
                                 height="20"
                                 viewBox="0 0 20 20">
                                <path d="M18.869 19.162l-5.943-6.484c1.339-1.401 2.075-3.233 2.075-5.178 0-2.003-0.78-3.887-2.197-5.303s-3.3-2.197-5.303-2.197-3.887 0.78-5.303 2.197-2.197 3.3-2.197 5.303 0.78 3.887 2.197 5.303 3.3 2.197 5.303 2.197c1.726 0 3.362-0.579 4.688-1.645l5.943 6.483c0.099 0.108 0.233 0.162 0.369 0.162 0.121 0 0.242-0.043 0.338-0.131 0.204-0.187 0.217-0.503 0.031-0.706zM1 7.5c0-3.584 2.916-6.5 6.5-6.5s6.5 2.916 6.5 6.5-2.916 6.5-6.5 6.5-6.5-2.916-6.5-6.5z"></path>
                            </svg>
                        </div>
                        <input id="search"
                               type="text"
                               name="sp"
                               value="{{ request()->get('sp') }}"
                               placeholder="{{ __('trx.search_term') }}...">
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="result-count mr-3">
                            <span>{{ $resultCount }} </span>{{ trans_choice('trx.author', $resultCount) }}
                        </div>
                        <base-button :role="'submit'">
                            {{ __('trx.search') }}
                        </base-button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
