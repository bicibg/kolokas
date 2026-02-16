<?php

namespace App\Livewire;

use App\Models\Recipe;
use Livewire\Attributes\On;
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

    #[On('recipeUpdated')]
    public function pullRecipe($slug)
    {
        $recipe = Recipe::where('slug', $slug)->first();
        if ($recipe && $recipe->id === $this->recipe->id) {
            $this->recipe = $recipe;
        }
    }

    public function favourite()
    {
        if (!auth()->check()) {
            $this->dispatch('flash-error', message: null, trans_key: __('trx.not_logged_in'));
            return;
        }
        if ($this->recipe->isFavourited()) {
            $this->recipe->unfavourite();
        } else {
            $this->recipe->favourite();
        }
        $this->recipe = $this->recipe->fresh();
        $this->dispatch('recipeUpdated', slug: $this->recipe->slug);
    }
}
