<div class="container pt-5">
    <div class="form-group">
        <div class="input-group mb-3 has-clear">
            <input type="text" class="form-control" wire:model.lazy="searchTerm" placeholder="Search by Keyword"
                   wire:key="recipes">
            @if($searchTerm)
                <div class="input-group-append form-control-clear form-control-feedback">
                    <span class="input-group-text clear" id="clear" wire:click="clearSearch">Clear</span>
                </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        @if($recipes->count())
            <div class="col-lg-12">
                <h5 class="text-center">
                    <i class="fa fa-cutlery" aria-hidden="true"></i>
                    {{ $recipes->count() }} {{ \Illuminate\Support\Str::plural('Recipe', $recipes->count()) }}
                </h5>
            </div>
        @endif
        @forelse($recipes as $recipe)
            <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch" wire:key="{{randKey()}}">
                @livewire('recipe-box', ['recipe'=>$recipe], key(randKey()))
            </div>
        @empty
            No results found with this search, please try something else.
        @endforelse
    </div>
</div>
