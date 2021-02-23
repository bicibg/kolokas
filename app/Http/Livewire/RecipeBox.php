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

    /**
     * @var $locale
     */
    public $locale;

    public function render()
    {
        return view('livewire.recipe-box');
    }

    public function mount(Recipe $recipe)
    {
        $this->locale = app()->getLocale();
        $this->recipe = $recipe;
    }

    public function hydrate()
    {
        app()->setLocale($this->locale);
    }

    public function favourite()
    {
        if (!auth()->check()) {
            $this->emit('flash-error', null, 'trx.not_logged_in');
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
