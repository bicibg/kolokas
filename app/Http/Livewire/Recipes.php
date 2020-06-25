<?php

namespace App\Http\Livewire;

use App\Recipe;
use Livewire\Component;

class Recipes extends Component
{
    public $searchTerm = '';

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        return view('livewire.recipes', [
            'recipes' => Recipe::wherePublished(true)->where('title', 'LIKE', $searchTerm)
                ->orWhere('description', 'LIKE', $searchTerm)->latest()->get(),
        ]);
    }
}
