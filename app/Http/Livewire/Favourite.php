<?php

namespace App\Http\Livewire;

use App\Models\Recipe;
use Livewire\Component;

class Favourite extends Component
{
    /**
     * @var Recipe
     */
    public $recipe;

    public function mount(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    public function render()
    {
        return <<<'blade'
            <a href="javascript:void(0);" title="{{ __('trx.add_to_favourites') }}" wire:click="favourite">
                <i class="fa @if($recipe->isFavourited()) fa-heart red @else fa-heart-o @endif"></i>
                <span class="d-inline-block">
                    {{ $recipe->favourites->count() }} {{ trans_choice('trx.likes', $recipe->favourites->count()) }}
                </span>
            </a>
        blade;
    }

    public function favourite()
    {
        if (!auth()->check()) {
            //display warning
            $this->emit('flash-error', null, __('trx.not_logged_in'));
            return;
        }
        if ($this->recipe->isFavourited()) {
            $this->recipe->unfavourite();
        } else {
            $this->recipe->favourite();
        }
        $this->recipe = $this->recipe->fresh();
    }
}
