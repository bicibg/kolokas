<?php

namespace App\Http\Livewire;

use App\Models\Recipe;
use Livewire\Component;

class RecipeBox extends Component
{
    /**
     * @var Recipe
     */
    public $recipe;

    public function render()
    {
        return view('livewire.recipe-box');
    }

    public function mount(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    public function favourite()
    {
        if (!auth()->check()) {
            //display warning
            $this->emit('flash-error', __('messages.general.not_loggedin'));
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
