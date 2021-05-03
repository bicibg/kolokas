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

    protected $listeners = ['recipeUpdated' => 'pullRecipe'];

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

    public function pullRecipe(Recipe $recipe) {
        if ($recipe->id === $this->recipe->id) {
            $this->recipe = $recipe;
        }
    }

    public function favourite()
    {
        if (!auth()->check()) {
            $this->emit('flash-error', null, __('trx.not_logged_in'));
            return;
        }
        if ($this->recipe->isFavourited()) {
            $this->recipe->unfavourite();
        } else {
            $this->recipe->favourite();
        }
        $this->recipe = $this->recipe->fresh();
        $this->emit('recipeUpdated', $this->recipe->slug);
    }
}
