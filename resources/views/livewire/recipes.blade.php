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
        <div class="col-md-3 col-sm-4 col-xs-6 d-flex align-items-stretch" wire:key="{{ $recipe->id . $recipe->title }}">
            @livewire('recipe-box', ['recipe'=>$recipe], key($recipe->id))
        </div>
    @empty
        No results found with this search, please try something else.
    @endforelse
</div>
