<?php

namespace App\Http\Livewire;

use App\Recipe;
use Livewire\Component;

class Recipes extends Component
{
    protected $listeners = ['searchTerm' => 'filterResults'];
    public $recipes = [];
    public function filterResults($searchTerm) {
        $this->recipes = Recipe::wherePublished(true)->where('title', 'LIKE', $searchTerm)
            ->orWhere('description', 'LIKE', $searchTerm)->latest()->get();
    }

    public function mount() {
        $this->recipes = Recipe::wherePublished(true)->latest()->get();
    }

    public function render()
    {
        return view('livewire.recipes');
    }
}
